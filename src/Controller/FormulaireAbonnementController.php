<?php

namespace App\Controller;

use App\Entity\Lesson;
use App\Repository\LessonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    public function offre($sport)
    {
        $offre = $this->lessonRepository->findOneBy(['name' => $sport]);
        $prix = $offre->getPrice();

        return $this->render('offres_abonnement/offre.html.twig', [
            'price' => $prix,
        ]);
    }
}
