<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class NotFoundSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Environment $twig,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', -10],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        // Only handle 404 errors
        if (!$exception instanceof NotFoundHttpException) {
            return;
        }

        $response = new \Symfony\Component\HttpFoundation\Response(
            $this->twig->render('pages/errors/404.html.twig'),
            404
        );

        $event->setResponse($response);
    }
}
