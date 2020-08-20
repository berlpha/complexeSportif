<?php

namespace App\Controller;

use App\Entity\Administrator;
use App\Form\AdministratorType;
use App\Repository\AdministratorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/administrator")
 */
class AdministratorController extends AbstractController
{
    /**
     * @Route("/", name="administrator_index", methods={"GET"})
     */
    public function index(AdministratorRepository $administratorRepository): Response
    {
        return $this->render('administrator/index.html.twig', [
            'administrators' => $administratorRepository->findAll(),
            'navig' => 'administrator',
        ]);
    }

    /**
     * @Route("/new", name="administrator_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $administrator = new Administrator();
        $form = $this->createForm(AdministratorType::class, $administrator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($administrator);
            $entityManager->flush();

            return $this->redirectToRoute('administrator_index');
        }

        return $this->render('administrator/new.html.twig', [
            'administrator' => $administrator,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="administrator_show", methods={"GET"})
     */
    public function show(Administrator $administrator): Response
    {
        return $this->render('administrator/show.html.twig', [
            'administrator' => $administrator,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="administrator_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Administrator $administrator): Response
    {
        $form = $this->createForm(AdministratorType::class, $administrator);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('administrator_index');
        }

        return $this->render('administrator/edit.html.twig', [
            'administrator' => $administrator,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="administrator_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Administrator $administrator): Response
    {
        if ($this->isCsrfTokenValid('delete'.$administrator->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($administrator);
            $entityManager->flush();
        }

        return $this->redirectToRoute('administrator_index');
    }
}
