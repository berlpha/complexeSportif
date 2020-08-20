<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'navig' => 'user',
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, EntityManagerInterface $emi): Response
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
            $emi->persist($user);
            $emi->flush();

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
    public function edit($id, Request $request, EntityManagerInterface $emi, UserPasswordEncoderInterface $userPasswordEncoder, UserRepository $userRepository): Response
    {
        $user = $userRepository->findOneBy(['id' => $id]);

        $form = $this->createForm(UserType::class, $user);

        $oldPassword = $user->getPassword();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($form->get('password')->getData() != '') {
                //$password = $userPasswordEncoder->encodePassword($user, $form->get('Password')->getData(), $user->getSalt());
                $password = $userPasswordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
            }else {
                $user->setPassword($oldPassword);
            }

            //$this->getDoctrine()->getManager()->flush();
            $emi->persist($user);
            $emi->flush();

            $this->addFlash('message', "La modification s'est effectuée avec succès!" );

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
