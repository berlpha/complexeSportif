<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Member;
use App\Entity\Subscription;
use App\Entity\User;
use App\Form\AdminSubscriptionType;
use App\Form\SubscriptionType;
use App\Repository\LessonRepository;
use App\Repository\MemberRepository;
use App\Repository\SubscriptionRepository;
use App\Repository\UserRepository;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/admin/subscription")
 */
class SubscriptionController extends AbstractController
{
    /**
     * @Route("/", name="subscription_index", methods={"GET"})
     */
    public function index(SubscriptionRepository $subscriptionRepository): Response
    {
        return $this->render('subscription/index.html.twig', [
            'subscriptions' => $subscriptionRepository->findAll(),
            'navig' => 'subscription',
        ]);
    }

    /**
     * @Route("/adminSubscription", name="app_adminSubscription", methods={"GET", "POST"})
     */
    public function adminSubscription(Request $request, UserRepository $userRepository, SubscriptionRepository $subscriptionRepository, LessonRepository $lessonRepository, TranslatorInterface $translator, MemberRepository $memberRepository)
    {
        $users = $memberRepository->findAll(); // Get only members (not coach/admin)

        $lessons = $lessonRepository->findAll();

        $prices = [];

        foreach ($lessons as $lesson) {
            $prices[$lesson->getName()] = $lesson->getPrice();
        }

        // Verify if the form is submitted
        if ($request->isMethod('POST')) {

            $donnees = $request->request;

            $subscription = new Subscription();

            $member = $userRepository->findOneBy(array('id' => $donnees->get('member')));
            $subscription->setMember($member);
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

                $member_abonnements = $subscriptionRepository->getSubcription($member, $lesson_object, $debut, $fin);

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
                    $this->AddFlash('error', "Subscription for {$lesson_object->getName()} already exists");
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

                return $this->redirectToRoute('subscription_index');
            }
        }

        return $this->render('offres_abonnement/adminSubscription.html.twig', ['users' => $users,
            'lessons' => $prices,]);
    }

    /**
     * @Route("/{id}", name="subscription_show", methods={"GET"})
     */
    public
    function show(Subscription $subscription): Response
    {
        return $this->render('subscription/show.html.twig', [
            'subscription' => $subscription,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="subscription_edit", methods={"GET","POST"})
     */
    public
    function edit(Request $request, Subscription $subscription): Response
    {
        $form = $this->createForm(SubscriptionType::class, $subscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('subscription_index');
        }

        return $this->render('subscription/edit.html.twig', [
            'subscription' => $subscription,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="subscription_delete", methods={"DELETE"})
     */
    public
    function delete(Request $request, Subscription $subscription): Response
    {
        if ($this->isCsrfTokenValid('delete' . $subscription->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($subscription);
            $entityManager->flush();
        }

        return $this->redirectToRoute('subscription_index');
    }


    /**
     * @Route("/moreSubscription", name="app_moreSusciption")
     */
    /*public function getMoreSubscriptions(TranslatorInterface $translator, SubscriptionRepository $subscriptionRepository)
    {
        $subscription = new Subscription();

            $member = $subscription->getMember();
            $lessons = $member->get('lesson');
            $debut = $subscription->getCreatedAt();
            $fin = $subscription->getFinishedAt();

            $subcriber = $subscriptionRepository->getSubcription($member, $lessons[], $debut, $fin);

        if ($subscription == null) {

            foreach ($subcriber as $sub) {

                $priceLes = [];
                $priceSub = 0.0;
                $duration = $fin - $debut;
                $type = $subscription->getType();

                $priceLes[$lessons->getName()] = $lessons->getPrice();

                if ($type === 'Enfant') {
                    $price = $priceLes[] * 0.85;
                }
                else {
                    $price = $priceLes * 1.25;
                }

                $priceT = $price;

                if ($duration === '3 months') {
                    $price = $priceT * 3;
                }
                elseif ($duration === '6 months') {
                    $price = $priceT * 6 - ($price / 2);
                }
                else {
                    $price = $prixT * 11;
                }

                $priceSub += floatval($price);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($subscription);
                $entityManager->flush();

                $message = $translator->trans("Registration for these courses has been successfully completed.");
                $this->addFlash('message', $message);

                return $this->redirectToRoute('app_memberInterface');
            }
        }
        else
        {
            $message1 = $translator->trans("Registration for these courses has not been successfully completed.");
            $this->addFlash('message', $message1);;
        }

        return $this->render('offres_abonnement/moreSubscription.html.twig');
    } */
}
