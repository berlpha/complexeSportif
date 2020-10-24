<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use App\Form\ContactType;
use App\Form\EditProfilType;
use App\Form\ForgottenPasswordType;
use App\Form\ForgottePasswordType;
use App\Form\ProfilType;
use App\Form\RegistrationType;
use App\Form\ResetPasswordType;
use App\Repository\ClubRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

class SecurityController extends AbstractController
{
    private $emi;
    private $translator;

    public function __construct(EntityManagerInterface $emi, TranslatorInterface $translator)
    {
        $this->emi = $emi;
        $this->translator = $translator;
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout", methods={"GET"})
     */
    public function logout()
    {
        //throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        return $this->redirectToRoute('app_home');
    }

    /**
     * @Route("/registration", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();

        $bouton = $this->translator->trans('Register');
       $form = $this->createForm(RegistrationType::class, $user)
       ->add($bouton, SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary btn-block'
            ]
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // Encodage du mot de passe
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));

            // Les deux lignes suivantes permettent d'attribuer le rôle membre lors de l'enregistrement
            $role = $user->getRoles();
            $user->setRoles($role);
            //Je vais générer le token d'activation
            $user->setActivateToken(md5(uniqid()));

            /* $user->setIsActive(true); */

            $this->emi->persist($user);

            $this->emi->flush();

            $message = $this->translator->trans('User modified successfully');

            $this->addFlash('message', $message);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/registration.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/forgottenPassword", name="app_forgottenPassword")
     */
    public function forgotten_password(Request $request, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator)
    {
        $form = $this->createForm(ForgottenPasswordType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            // Je vais récupérer les données contenues dans la form
            $donnees = $form->getData();
            // Je vérifie si un user à cet email
            $user = $this->emi->getRepository(UserRepository::class)->findOneBy($donnees['email']);
            if(!$user)
            {
                $message = $this->translator->trans("This email doesn't exist.");
                $this->addFlash('danger', $message);

                return $this->redirectToRoute('app_login');
            }
            // Je génère un token
            $token = $tokenGenerator->generateToken();
            try
            {
                $user->setResetToken($token);
            } catch (\Exception $exception)
            {
                $message = $this->translator->trans("An error has occurred");
                $this->addFlash('warning', $message.$exception->getMessage());
                return $this->redirectToRoute('app_login');
            }
            // Je génère l'url de réinitialisation de mot de passe
            $url = $this->generateUrl('app_resetPassword', ['token' => $token]);
            // Ensuite je vais envoyer le message
            $mes = $this->translator->trans("Forgot your password");
            $message = (new \Swift_Message($mes))
                ->setFrom('beralpha08@yahoo.fr')
                ->setTo($user->getEmail())
                ->setBody(
                    "<p>Bonjour,</p><p>Une demande de réinitialisation de mot de passe a été effectuée pour l'application 
                               du complexe sportif AS-Molenbeekoise. Veuillez cliquer sur le lien suivant : " . $url . "</p>", "text/html"
                )
            ;
            $mailer->send($message);
            $this->addFlash('message', 'un email de réinitialisation de mot de passe vous a été envoyé');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/forgotten_password.html.twig', [
            'emailForm' => $form->createView(),
        ]);


        /*if($request->isMethod('POST'))
        {
            $email = $request->request-$this->get('email');

            $user = $this->emi->getRepository(User::class)->findOneBy([$email]);

            if($user === null)
            {
                $emailInconnu = $this->translator->trans('Unkwnown email');
                $this->addFlash('danger', $emailInconnu);

                return $this->redirectToRoute('app_home');
            }

            $token = $tokenGenerator->generateToken();

            try
            {
                $user->setResetToken($token);
                $this->emi->persist($user);
                $this->emi->flush();
                return $this->redirectToRoute('app_home');
            }
            catch (\Exception $e)
            {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('app_home');
            }

            $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            $messag = $this->translator->trans("Click on this link to reset your password!");
            $message = (new \Swift_Message('Forgot password'))
                ->setFrom('beralpha08@yahoo.fr')
                ->setTo($user->getEmailAddress())
                ->setBody($messag .$url, 'text/html');

            $mailer->send($message);

            $emailEnvoye = $this->translator->trans('Email sent');
            $this->addFlash('notice', $emailEnvoye);

            return $this->redirectToRoute('app_home');
        }

        return $this->render('security/forgotten_password.html.twig');*/
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/changePassword", name="app_changePassword")
     */
    public function changePassword(Request $request,UserPasswordEncoderInterface $encoder)
    {

        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {


            //$oldPassword = $request->request->get('etiquettebundle_user')['oldPassword'];
            //$oldPassword = $form['oldPassword']  $request->request->get('name');
            //$data= $form->getData();
            // Si l'ancien mot de passe est bon

            if /*($encoder->isPasswordValid($user, $oldPassword))*/ ($user->getPassword() === $encoder->encodePassword($user, $request->request->get('oldPassword'))) {
                $newEncodedPassword = $encoder->encodePassword($user, $request->request->get('oldPassword'));
                $user->setPassword($newEncodedPassword);

                $this->emi->persist($user);
                $this->emi->flush();

                $changepwd = $this->translator->trans('Your password has been changed!');
                $this->addFlash('notice', $changepwd);

                return $this->redirectToRoute('profile');
            } else {
                $pwdIncorrect = $this->translator->trans('Old incorrect password');
                $form->addError(new FormError($pwdIncorrect));
            }
        }

        return $this->render('security/change_password.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/Profil", name="app_editProfil")
     */
    public function editProfil(Request $request, UserPasswordEncoderInterface $userPasswordEncoder)
    {
//        $user = $this->getDoctrine()->getRepository(User::class)->find($this->getUser()->getId());

        $user = $this->getUser();

        $bouton = $this->translator->trans('Modify');

        $form = $this->createForm(EditProfilType::class, $user)
            ->add($bouton, SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary btn-block'
                ]
            ]);

        //$oldhashpwd = $this->getUser()->getPassword();
        $oldhashpwd = $user->getPassword();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('Password')->getData() != '') {
                //$password = $userPasswordEncoder->encodePassword($user, $form->get('Password')->getData(), $user->getSalt());
                //$password = $userPasswordEncoder->encodePassword($user, $user->getPassword(), $user->getSalt());
                $password = $userPasswordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
            } else {
                $user->setPassword($oldhashpwd);
            }

            /* $user->setIsActive(true); */

            $this->emi->persist($user);

            $this->emi->flush();

            $message =$this->translator->trans('Your account has been successfully modified!');
            $this->addFlash('message', $message);

            // Retour à la page précédente
            //return $this->redirect($request->headers->get('referer'));
//            $referer = $request->headers->get('referer');
//            return $this->redirect($referer);

        }
        return $this->render('security/edit_profil.html.twig',array('form'=>$form->createView(),));
    }

    /**
     * @Route("/resetPassword", name="app_resetPassword")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $encoder)
    {
        $user = $this->emi->getRepository(User::class)->findOneBy(['reset_token' => $token]);

        if(!$user)
        {
            $messageDanger = $this->translator->trans('This token is unknown!');
            $this->addFlash('danger', $messageDanger);
            return $this->redirectToRoute('app_login');
        }
        // Si le formulaire est envoyé par en méthode post
        if($request->isMethod('POST'))
        {
            // Je supprime le token
            $user->setResetToken(null);

            // Je vais chiffrer le mot de passe
            $user->setPassword($encoder->encodePassword($user, $request->request->get('password')));
            $this->emi->persist($user);
            $this->emi->flush();

            $message = $this->translator->trans('Your password has been successfully changed!');
            $this->addFlash('message', $message);
            return $this->redirectToRoute('app_login');
        }
        else
        {
            return $this->render('security/reset_password.html.twig', [
                'token' => $token
            ]);
        }

       /* if($request->isMethod('POST'))
        {
            $user = $this->emi->getRepository(User::class)->findOneByActivateToken($token);

            if($user === null)
            {
                $this->addFlash('danger', 'Unknow token');

                return $this->redirectToRoute('app_home');
            }

            $user->setResetToken(null);

            $user->setPassword($encoder->encodePassword($user, $request->request->get('password')));

            $this->emi->flush();

            $this->addFlash('notice', 'Update password');

            return $this->redirectToRoute('app_home');
        }
        else
        {
            return $this->render('security/reset_Password.html.twig', [
                'token' => $token
            ]);
        } */
    }

    /**
     * @Route("/activate/{token}", name="app_activateToken")
     */
    public function activateToken($token, UserRepository $userRepository)
    {
        // Je vais vérifier si le user à ce token
        $user = $userRepository->findOneBy(['activateToken' => $token]);

        if (!$user)
        {
            $message = $this->translator->trans("This user doesn't exist in this database.");
            //Erreur 404
            throw $this->createNotFoundException();
        }
        // Suppression de token
        $user->setActivateToken(null);
        $this->emi->persist($user);
        $this->emi->flush();

        $message = $this->translator->trans('Your user account has been activated!');
        $this->addFlash('message', $message);
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/profilUtilisateur", name="app_accountProfil")
     */
    public function accountProfil(Request $request)
    {
        $user = $this->getUser();

        $bouton = $this->translator->trans('Modify');

        $form = $this->createForm(ProfilType::class, $user)
        ->add($bouton, SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary btn-block'
            ]
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->emi->persist($user);
            $this->emi->flush();

            $messageProfil = $this->translator->trans('Profile has been successfully modified!');
            $this->addFlash('message', $messageProfil);
            //return $this->redirectToRoute('user_show', ['username' => $user->getUsername()]);
        }
        return $this->render('security/edit_profil.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/changePwd", name="app_changePwd")
     */
    public function changerPassword(Request $request, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        if ($request->isMethod('POST'))
        {
            $user = $this->getUser();

            if ($request->request->get('password') && $request->request->get('password2'))
            {
                $user->setPassword($userPasswordEncoder->encodePassword($user, $request->request->get('password')));
                $this->emi->persist($user);
                $this->emi->flush();

                $message = $this->translator->trans('Password has been changed successfully!');
                $this->addFlash('message', $message);
            }
            else
            {
                $errorMessage = $this->translator->trans('The two passwords must be identical');
                $this->addFlash('error', $errorMessage);
            }
        }

        return $this->render('security/modify_password.html.twig');
    }

    /**
     * @Route("/sendMessage", name="app_sendMessage")
     */
    public function sendMessage(Request $request, \Swift_Mailer $mailer, ClubRepository $clubRepository)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $contact = $form->getData();
            //dd($contact);
            // Envoi d'e-mail
            $mes = $this->translator->trans("New message");
            $message = (new \Swift_Message($mes))
                // Je vais attribuer un expéditeur
                ->setFrom($contact['email'])
                // Je vais attribuer un destinateur
                ->setTo('beralpha08@yahoo.fr')
                // Je vais créer le message
                ->setBody(
                    $this->renderView(
                        'home/emailSender.html.twig', compact('contact')
                    ),
                    'text/html'
                )
            ;
            // je vais envoyer le message
            $mailer->send($message);

            $mess = $this->translator->trans('The message has been sent');
            $this->addFlash('message', $mess);

            return $this->redirectToRoute('app_home');

        }
        $clubs = $clubRepository->findAll();
        return $this->render('home/contact.html.twig', [
            'form' => $form->createView(),
            'clubs' => $clubs,
        ]);
    }

}
