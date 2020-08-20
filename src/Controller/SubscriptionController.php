<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Member;
use App\Entity\Subscription;
use App\Entity\User;
use App\Form\SubscriptionType;
use App\Repository\LessonRepository;
use App\Repository\SubscriptionRepository;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/new", name="subscription_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $subscription = new Subscription();

        $form = $this->createForm(SubscriptionType::class, $subscription);

        //$prix = $request->request->get('lesson')->get('price');

        //dd($prix);

        /*
        $type = $subscription->getType();
        $prix =
        $prixT = 0.0;

        dd($prix);

        if( $type === 'Basic' )
        {
            $prixT = $subscription->setPrice($prix);
        }
        elseif ($type === 'Enfant')
        {
            $prixT = $subscription->setPrice($prix - ($prix * 15/100));
        }
        elseif ($type === 'VIP')
        {
            $prixT = $subscription->setPrice($prix * 1.25);
        }
        else{
            //throw new NotFoundException('');
            echo 'Désolé, il n\'y a pas encore de prix pour ce sport!';
        }

        $subscription->setPrice($prixT);
        $subscription->getPrice();  */

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

//            $lesson = $form->get('lesson');
//            $prixLesson = $lesson->getPrice();
//            $prixSubscription = $subscription->setPrice($prixLesson);
//            $subscription->getPrice();
//            var_dump($prixSubscription);
//            dd();


            /*$prixLesson = $form->get('lesson')->get('price');
            dump($prixLesson);
            die();*/

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subscription);
            $entityManager->flush();

            return $this->redirectToRoute('subscription_index');
        }

        return $this->render('subscription/new.html.twig', [
            'subscription' => $subscription,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="subscription_show", methods={"GET"})
     */
    public function show(Subscription $subscription): Response
    {
        return $this->render('subscription/show.html.twig', [
            'subscription' => $subscription,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="subscription_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Subscription $subscription): Response
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
     * @Route("/{id}", name="subscription_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Subscription $subscription): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subscription->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($subscription);
            $entityManager->flush();
        }

        return $this->redirectToRoute('subscription_index');
    }
}
