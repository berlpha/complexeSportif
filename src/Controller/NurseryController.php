<?php

namespace App\Controller;

use App\Entity\Nursery;
use App\Form\NurseryType;
use App\Repository\NurseryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/nursery")
 */
class NurseryController extends AbstractController
{
    /**
     * @Route("/list", name="nursery_index", methods={"GET"})
     */
    public function index(NurseryRepository $nurseryRepository): Response
    {
        return $this->render('nursery/index.html.twig', [
            'navig' => 'nursery',
            'nurseries' => $nurseryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="nursery_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $nursery = new Nursery();
        $form = $this->createForm(NurseryType::class, $nursery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($nursery);
            $entityManager->flush();

            return $this->redirectToRoute('nursery_index');
        }

        return $this->render('nursery/new.html.twig', [
            'nursery' => $nursery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="nursery_show", methods={"GET"})
     */
    public function show(Nursery $nursery): Response
    {
        return $this->render('nursery/show.html.twig', [
            'nursery' => $nursery,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="nursery_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Nursery $nursery): Response
    {
        $form = $this->createForm(NurseryType::class, $nursery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('nursery_index');
        }

        return $this->render('nursery/edit.html.twig', [
            'nursery' => $nursery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="nursery_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Nursery $nursery): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nursery->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($nursery);
            $entityManager->flush();
        }

        return $this->redirectToRoute('nursery_index');
    }
}
