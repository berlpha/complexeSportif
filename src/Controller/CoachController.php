<?php

namespace App\Controller;

use App\Entity\Coach;
use App\Entity\Lesson;
use App\Form\CoachType;
use App\Helpers\MarkdownHelper;
use App\Repository\CoachRepository;
use App\Repository\LessonRepository;
use App\Repository\MemberRepository;
use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use cebe\markdown\Markdown;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/coach")
 */
class CoachController extends AbstractController
{
    /**
     * @Route("/", name="coach_index", methods={"GET"})
     */
    public function index(CoachRepository $coachRepository): Response
    {
        return $this->render('coach/index.html.twig', [
            'coaches' => $coachRepository->findAll(),
            'navig' => 'coach',
        ]);
    }

    /**
     * @Route("/new", name="coach_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $coach = new Coach();
        $form = $this->createForm(CoachType::class, $coach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($coach);
            $entityManager->flush();

            return $this->redirectToRoute('coach_index');
        }

        return $this->render('coach/new.html.twig', [
            'coach' => $coach,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="coach_show", methods={"GET"})
     */
    public function show(Coach $coach): Response
    {
        return $this->render('coach/show.html.twig', [
            'coach' => $coach,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="coach_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Coach $coach): Response
    {
        $form = $this->createForm(CoachType::class, $coach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('coach_index');
        }

        return $this->render('coach/edit.html.twig', [
            'coach' => $coach,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="coach_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Coach $coach): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coach->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($coach);
            $entityManager->flush();
        }

        return $this->redirectToRoute('coach_index');
    }

    /**
     * @Route("/coach/listeActivities", name="app_listeCoachActivities")
     */
    public function listeCoachActivities(CoachRepository $coachRepository)
    {

        $user = $coachRepository->findOneBy(['username' => $this->getUser()->getUsername()]);
        return $this->render('coach/listeCoachActivities.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/coach/listeInscrits", name="app_listeInscrits")
     */
    public function ListeInscrit(SubscriptionRepository $subscriptionRepository)
    {
        $subscribers = $subscriptionRepository->findOneBy(['lesson' => $this->getUser()->getUsername()]);

        return $this->render('subscription/listeAbonnes.html.twig', [
            'subscribers' => $subscribers,
        ]);
    }

    /**
     * @Route("/coach/listeParticipants/{id}", name="app_listeParticipants")
     */
    public function listePaticipant(LessonRepository $lessonRepository, $id)
    {
        $lesson = $lessonRepository->findOneBy(['id' => $id]);

        return $this->render('coach/listeParticipant.html.twig', [
            'lesson' => $lesson,
        ]);
    }
}
