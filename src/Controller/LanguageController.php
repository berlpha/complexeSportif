<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LanguageController extends AbstractController
{
//    /**
//     * @Route("/change_language/{locale}", name="app_changeLanguage")
//     */
//    public function changeLanguage($locale, Request $request)
//    {
//        // Je vais stocker la langue demandée dans la session
//        $request->getSession()->set('_locale', $locale);
//        //$request->setLocale($locale);
//
//        // Je reviens sur la page précédente
//        return $this->redirect($request->headers->get('referer'));
//
//    }

    /**
     * @Route("/change_languageFr/fr", name="app_changeLanguageFr")
     */
    public function changeLanguageFr(Request $request)
    {
        // Je vais stocker la langue demandée dans la session
        $request->getSession()->set('_locale', 'fr');
        //$request->setLocale('fr');

        // Je reviens sur la page précédente
        return $this->redirect($request->headers->get('referer'));

    }

    /**
     * @Route("/change_languageNl/nl", name="app_changeLanguageNl")
     */
    public function changeLanguageNl(Request $request)
    {
        // Je vais stocker la langue demandée dans la session
        $request->getSession()->set('_locale', 'nl');
        //$request->setLocale('nl');

        // Je reviens sur la page précédente
        return $this->redirect($request->headers->get('referer'));

    }

    /**
     * @Route("/change_languageEn/en", name="app_changeLanguageEn")
     */
    public function changeLanguageEn(Request $request)
    {
        // Je vais stocker la langue demandée dans la session
        $request->getSession()->set('_locale', 'en');
        //$request->setLocale('en');

        // Je reviens sur la page précédente
        return $this->redirect($request->headers->get('referer'));

    }
}
