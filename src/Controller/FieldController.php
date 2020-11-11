<?php

namespace App\Controller;

use App\Entity\Field;
use App\Form\FieldType;
use App\Helpers\MarkdownHelper;
use App\Repository\FieldRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/field")
 */
class FieldController extends AbstractController
{
    /**
     * @Route("/list", name="field_index", methods={"GET"})
     */
    public function index(FieldRepository $fieldRepository, Request $request, PaginatorInterface $paginator, MarkdownHelper $helper): Response
    {
        $donnees = $fieldRepository->findAll();
        $fields = $helper->parse($request, $paginator, $donnees);
        return $this->render('field/index.html.twig', [
            'navig' => 'field',
            'fields' => $fields,
        ]);
    }

    /**
     * @Route("/new", name="field_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $field = new Field();
        $form = $this->createForm(FieldType::class, $field);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($field);
            $entityManager->flush();

            return $this->redirectToRoute('field_index');
        }

        return $this->render('field/new.html.twig', [
            'field' => $field,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="field_show", methods={"GET"})
     */
    public function show(Field $field): Response
    {
        return $this->render('field/show.html.twig', [
            'field' => $field,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="field_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Field $field): Response
    {
        $form = $this->createForm(FieldType::class, $field);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('field_index');
        }

        return $this->render('field/edit.html.twig', [
            'field' => $field,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="field_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Field $field): Response
    {
        if ($this->isCsrfTokenValid('delete'.$field->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($field);
            $entityManager->flush();
        }

        return $this->redirectToRoute('field_index');
    }
}
