<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Subscription;
use App\Form\AdminSubscriptionType;
use App\Form\MemberType;
use App\Form\SubscriptionType;
use App\Repository\BookingRepository;
use App\Repository\LessonRepository;
use App\Repository\MemberRepository;
use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/member")
 */
class MemberController extends AbstractController
{
    /**
     * @Route("/", name="member_index", methods={"GET"})
     */
    public function index(MemberRepository $memberRepository): Response
    {
        return $this->render('member/index.html.twig', [
            'members' => $memberRepository->findAll(),
            'navig' => 'member',
        ]);
    }

    /**
     * @Route("/new", name="member_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        //$member->instanceOf('user');

        $member = new Member();
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($member);
            $entityManager->flush();

            return $this->redirectToRoute('member_index');
        }

        return $this->render('member/new.html.twig', [
            'member' => $member,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="member_show", methods={"GET"})
     */
    public function show(Member $member): Response
    {
        return $this->render('member/show.html.twig', [
            'member' => $member,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="member_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Member $member): Response
    {
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('member_index');
        }

        return $this->render('member/edit.html.twig', [
            'member' => $member,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="member_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Member $member): Response
    {
        if ($this->isCsrfTokenValid('delete'.$member->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($member);
            $entityManager->flush();
        }

        return $this->redirectToRoute('member_index');
    }

    /**
     * @Route("/member/memberSubscription", name="app_memberSubscription")
     */
    public function abonnement(Request $request, LessonRepository $lessonRepository, SubscriptionRepository $subscriptionRepository, TranslatorInterface $translator)
    {
        $user = $this->getUser();


        $lessons = $lessonRepository->findAll();

        $prices = [];

        foreach ($lessons as $lesson) {
            $prices[$lesson->getName()] = $lesson->getPrice();
        }

        // Verify if the form is submitted
        if ($request->isMethod('POST')) {

            $donnees = $request->request;

            $subscription = new Subscription();

            $subscription->setMember($user);
            $lessons = $donnees->get('sport');

            $debut = new \DateTime('now');

            $type = $donnees->get('customRadio');
            $subscription->setType($type);
            $duration = $donnees->get('customRadiod');

            $fin = new \DateTime("today +{$duration} months");
            $subscription->setFinishedAt($fin);
            $price = 0;
            $error = false;

            foreach ($lessons as $lesson) {

                $lesson_object = $lessonRepository->findOneBy(array('id' => $lesson));

                $member_abonnements = $subscriptionRepository->getSubcription($user, $lesson_object, $debut, $fin);

                if (count($member_abonnements) == 0) {

                    $priceLes = $lesson_object->getPrice();

                    $priceSub = $priceLes;

                    if ($type === 'Enfant') {
                        $priceSub = $priceLes * 0.85;
                    } else if ($type === 'VIP') {
                        $priceSub = $priceLes * 1.25;
                    }

                    if ($duration === '3') {
                        $priceSub *= 3;
                    } else if ($duration === '6') {
                        $priceSub = $priceSub * 6 - ($priceSub / 2);
                    } else if ($duration === '12') {
                        $priceSub *= 11;
                    }
                    $price = $priceSub;
                    $subscription->addLesson($lesson_object);
                } else {
                    $message = $translator->trans("Your");
                    $message1 = $translator->trans("membership is still valid");
                    $this->AddFlash('error', " $message {$lesson_object->getName()} $message1.");
                    $error = true;
                }
            }

            if (!$error) {

                $subscription = $subscription->setPrice($price);
                $subscription->setDescription("New subscription"); // To change
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($subscription);
                $entityManager->flush();

                $message = $translator->trans("Registration for these courses has been successfully completed.");

                $this->addFlash('message', $message);

                return $this->redirectToRoute('member_index');
            }

        }

        else
        {
            $message2 = $translator->trans("You did not choose sport");
            $this->addFlash('message', $message2);
        }

        return $this->render('offres_abonnement/moreSubscription.html.twig', [
            'lessons' => $prices
        ]);
    }

    /**
     * @Route("/member/myLessons", name="app_memberLessons")
     */
    public function myLessons(SubscriptionRepository $subscriptionRepository)
    {
        $subscriptions = $subscriptionRepository->findBy(['member' => $this->getUser()]);

        return $this->render('member/myLessons.html.twig', [
            'subscriptions' => $subscriptions,
        ]);

    }

    /**
     * @Route("member/reservation", name="app_memberReservation")
     */
    public function localReservation(BookingRepository $bookingRepository)
    {
        $booking = $bookingRepository->findOneBy(['members' => $this->getUser()]);
        return $this->render('member/reservationLocal.html.twig', [
            'booking' => $booking,
        ]);
    }
}
