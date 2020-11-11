<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Helpers\MarkdownHelper;
use App\Repository\UserRepository;
use cebe\markdown\Markdown;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/admin/user")
 */
class UserController extends AbstractController
{
    private $emi;
    private $translation;

    public function __construct(EntityManagerInterface $emi, TranslatorInterface $translator)
    {
        $this->emi = $emi;
        $this->translation = $translator;
    }

    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository, Request $request, PaginatorInterface $paginator, MarkdownHelper $helper): Response
    {
        $donnees = $userRepository->findAll();

        $users = $helper->parse($request, $paginator, $donnees);

        return $this->render('user/index.html.twig', [
            'navig' => 'user',
            'users' => $users,
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $userPasswordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Haschage du mot de passe
            $user->setPassword($userPasswordEncoder->encodePassword($user, $user->getPassword()));

            //$role = $user->getRoles();
            //$user->setRoles($role);

            //Je vais générer le token d'activation
            $user->setActivateToken(md5(uniqid()));

            // Persistence et envoi dans la base de données
            $this->emi->persist($user);
            $this->emi->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit($id, Request $request, UserPasswordEncoderInterface $userPasswordEncoder, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(['id' => $id]);

        $form = $this->createForm(UserType::class, $user);

        //$oldPassword = $user->getPassword();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($form->get('Password')->getData() !== null) {
                //$password = $userPasswordEncoder->encodePassword($user, $form->get('Password')->getData(), $user->getSalt());
                $password = $userPasswordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
            }else {
                $oldPassword = $user->getPassword();
                $user->setPassword($oldPassword);
            }

            //$this->getDoctrine()->getManager()->flush();
            $this->emi->persist($user);
            $this->emi->flush();
            $message = $this->translation->trans("The modification was carried out successfully.");
            $this->addFlash('message', $message );

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}
