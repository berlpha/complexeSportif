<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Repository\LessonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class FormulaireAbonnementController extends AbstractController
{
    private $lessonRepository;

    public function __construct(LessonRepository $lessonRepository)
    {
        $this->lessonRepository = $lessonRepository;
    }

    /**
     * @Route("/offres/abonnement", name="app_offres_abonnement")
     */
    public function index()
    {
        return $this->render('menus/menusGestion/menuAbonnement.html.twig', [
            'controller_name' => 'FormulaireAbonnementController',
        ]);
    }

    /**
     * @Route("/offres/abonnement/{sport}", name="app_offre")
     */
    public function offre($sport, TranslatorInterface $translator)
    {
        $offre = $this->lessonRepository->findOneBy(['name' => $sport]);

        if ($offre)
        {
            $prix = $offre->getPrice();
        }
        else
        {
            $message = $translator->trans('For the moment, this sport is not yet encoded in the database');
            $this->addFlash('message', $message);
        }

        return $this->render('offres_abonnement/offre.html.twig', [
            'price' => $prix,
        ]);


    }

    /**
     * @Route("/sport/price", name="app_sportPrice")
     */
    public function sportPrice(LessonRepository $lessonRepository)
    {
        $prices = [];

        $lessons = $lessonRepository->findAll();

        foreach ($lessons as $lesson){
            $prices[$lesson->getName()] = $lesson->getPrice();
        }

        return $this->render('offres_abonnement/moreSubscription.html.twig', [
            'lessons' => $prices,
        ]);
    }

}
