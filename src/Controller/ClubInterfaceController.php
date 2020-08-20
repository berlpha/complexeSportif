<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Contracts\Translation\TranslatorInterface;

class ClubInterfaceController extends AbstractController
{
    /**
     * @Route("/club/interface", name="club_interface")
     */
    public function index()
    {
        return $this->render('club_interface/index.html.twig', [
            'controller_name' => 'ClubInterfaceController',
        ]);
    }

    //Les annotations @Security et @IsGranted limitent l'accès aux contrôleurs:

    /**
     * Require ROLE_USER every controller method in this class.
     *
     * Will throuw a normal AccessDeniedException:
     *
     * @IsGranted("ROLE_ADMIN", message="Accès réservé aux administrateurs système ! Get out!")
     *
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        //$user = $this->getUser();

        if (!$this->isGranted('ROLE_ADMIN'))
        {
            throw new AccessDeniedException();
        }
        return $this->render('admin.html.twig');
    }

    /**
     * Require ROLE_USER every controller method in this  class.
     *
     * @IsGranted("ROLE_COACH")
     *
     * @Route("/coach", name="coach")
     */
    public function coach()
    {
        return $this->render('coach.html.twig');
    }

    /**
     * Require ROLE_USER every controller methode in this class.
     *
     * @isGranted("ROLE_MEMBER")
     *
     * @Route("/member", name="member")
     */
    public function member()
    {
        return $this->render('member.html.twig');
    }

}
