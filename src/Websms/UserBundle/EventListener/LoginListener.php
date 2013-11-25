<?php

namespace Websms\UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
* Listener responsible to change the redirection at the end of the login
*/
class LoginListener implements EventSubscriberInterface
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
    * {@inheritDoc}
    */
    public static function getSubscribedEvents()
    {
        return array();
        /*return array(
            FOSUserEvents::SECURITY_IMPLICIT_LOGIN => 'loginActionForm',
        );*/
    }

    public function loginActionForm(FormEvent $event)
    {
        $url = $this->router->generate('homepage');

        $event->setResponse(new RedirectResponse($url));
    }
}