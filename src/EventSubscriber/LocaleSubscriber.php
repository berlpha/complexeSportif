<?php


namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleSubscriber implements EventSubscriberInterface
{
    private $defaultLocale;

    public function __construct($defaultLocale = 'en')
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onkernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        if (!$request->hasPreviousSession())
        {
            return;
        }

        // Vérifier si le paramètres régionaux ont bien été définis comme paramètre de routage des paramètres régionaux
        if ($locale = $request->query->get('_locale'))
        {
            $request->setLocale($locale);
        }
        else // Si aucune locale explicite n'a été définie sur cette demande, utilisez-en une de la session
        {
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocale));
        }
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        // TODO: Implement getSubscribedEvents() method.

        // Doit être enregistré avant (c'est à dire avec une priorité plus élvée que l'écouteur de paramètres régionaux par defaut.
        return [
            KernelEvents::REQUEST => [['onkernelRequest', 20]],
        ];
    }
}