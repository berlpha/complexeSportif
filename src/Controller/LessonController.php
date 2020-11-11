<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Form\LessonType;
use App\Form\SearchType;
use App\Helpers\MarkdownHelper;
use App\Repository\LessonRepository;
use App\Service\FileUploader;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/lesson")
 */
class LessonController extends AbstractController
{
    private $lessonRepository;

    public function __construct(LessonRepository $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }

    /**
     * @Route("/", name="lesson_index", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator, MarkdownHelper $helper): Response
    {
        $donnees = $this->lessonRepository->findAll();

        $lessons = $helper->parse($request, $paginator, $donnees);

        return $this->render('lesson/index.html.twig', [
            'lessons' => $lessons,
            'navig' => 'lesson',
        ]);
    }

    /**
     * @Route("/new", name="lesson_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $lesson = new Lesson();
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $image */
            $image = $form->get('urlPicture')->getData();
            if ($image) {
                $newImage = $fileUploader->upload($image);
                $lesson->setUrlPicture($newImage);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lesson);
            $entityManager->flush();

            return $this->redirectToRoute('lesson_index');
        }

        return $this->render('lesson/new.html.twig', [
            'lesson' => $lesson,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lesson_show", methods={"GET"})
     */
    public function show(Lesson $lesson): Response
    {
        return $this->render('lesson/show.html.twig', [
            'lesson' => $lesson,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="lesson_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lesson $lesson): Response
    {
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lesson_index');
        }

        return $this->render('lesson/edit.html.twig', [
            'lesson' => $lesson,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lesson_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Lesson $lesson): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lesson->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lesson);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lesson_index');
    }

//    /**
//     * @Route("/recherche/{$name}", name="app_lesson_recherche")
//     */
//    public function rechercher($name)
//    {
//        $lessons = $this->lessonRepository->rechercher($name);
//
//        if (!$lessons)
//        {
//            $this->addFlash('message', 'Ce cours n\'existe encore de ce complexe sportif');
//        }
//
//        return $this->render('home/activity.html.twig', [
//            'lessons' => $lessons,
//        ]);
//    }

//    /**
//     * @Route("/lesson/search", name="app_lesson_search")
//     */
//    public function search(Request $request, Lesson $lesson)
//    {
//        $name = $lesson->getName();
//        $form = $this->createForm(SearchType::class, $name);
//        $form->handleRequest($request);
//
//        return $this->render('lesson/search.html.twig');
//    }

//    /**
//     * @Route("/search", name="app_search")
//     */
//    public function search(Request $request)
//    {
//        return $this->render('home/activity.hmtl.twig');
//    }

}
