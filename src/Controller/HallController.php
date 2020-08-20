<?php

namespace App\Controller;

use App\Entity\Hall;
use App\Form\HallType;
use App\Repository\HallRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/hall")
 */
class HallController extends AbstractController
{
    /**
     * @Route("/list", name="hall_index", methods={"GET"})
     */
    public function index(HallRepository $hallRepository): Response
    {
        return $this->render('hall/index.html.twig', [
            'navig' => 'hall',
            'halls' => $hallRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="hall_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $hall = new Hall();
        $form = $this->createForm(HallType::class, $hall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hall);
            $entityManager->flush();

            return $this->redirectToRoute('hall_index');
        }

        return $this->render('hall/new.html.twig', [
            'hall' => $hall,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hall_show", methods={"GET"})
     */
    public function show(Hall $hall): Response
    {
        return $this->render('hall/show.html.twig', [
            'hall' => $hall,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="hall_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Hall $hall): Response
    {
        $form = $this->createForm(HallType::class, $hall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hall_index');
        }

        return $this->render('hall/edit.html.twig', [
            'hall' => $hall,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="hall_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Hall $hall): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hall->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($hall);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hall_index');
    }
}
