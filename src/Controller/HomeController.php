<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Form\ContactType;
use App\Repository\ClubRepository;
use App\Repository\LessonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name = "app_home")
     */
    public function home(LessonRepository $lessonRepository) {
        return $this->render( 'base.html.twig', [
            'lessons' => $lessonRepository->findAll()
        ]);
    }

    /**
     * @Route("/admin", name = "app_interfaceAdmin")
     */
    public function homeAdmin(){
        return $this->render('admin.html.twig');
    }

    /**
     * @Route("/coach", name = "app_interfaceCoach")
     */
    public function homeCoach() {
        return $this->render('coach.html.twig');
    }

    /**
     * @Route("/member", name = "app_interfaceMember")
     */
    public function homeMember() {
        return $this->render('member.html.twig');
    }

    /**
     * @Route("/contactUs", name = "app_contactUs")
     */
    public function contactUs(Request $request, ClubRepository $clubRepository, \Swift_Mailer $mailer) {

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid() )
        {
            $contact = $form->getData();
            // Envoie d'email
            //dd($contact);
            $message = (new \Swift_Message('Hello Email'))
                // J'attribue l'expéditaire
                ->setFrom($contact['email'])
                // J'attribut le destinateur
                ->setTo('beralpha08@yahoo.fr')
                // On crée le message avec la vue twig
                ->setBody(
                    $this->renderView(
                        'home/emailSender.html.twig', compact('contact')
                    ),
                    'text/html'
                )
            ;

            // J'envoie le message
            $mailer->send($message);

            $this->addFlash('message', 'Le message a bien été envoyé avec succès!!');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/contact.html.twig', [
            'clubs' => $clubRepository->findAll(),
            'contactForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/view", name = "app_allLesson")
     */
    public function view(/*LessonRepository $lessonRepository*/) {
        return $this->render('home/activities.html.twig'/*, [
            'lessons' => $lessonRepository->findAll()
        ]*/);
    }

    /**
     * @Route("/aview/{id}", name = "app_showLesson", methods={"GET"})
     */
    public function one(Lesson $lesson) {

        return $this->render('home/activity.html.twig', [
            'lesson' => $lesson
        ]);
    }
}
