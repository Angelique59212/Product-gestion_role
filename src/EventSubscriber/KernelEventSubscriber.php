<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class KernelEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['displayKernelExceptionTriggered', 255],
                ['logKernelExceptionTriggered',1]
            ],
        ];
    }

    public function displayKernelExceptionTriggered(ExceptionEvent $event): void
    {
        $response = new Response();
        $response->setContent("
            <h1>Vous n'avez pas les droits !</h1>
        ");
        $event->setResponse($response);
    }
    public function logKernelExceptionTriggered(ExceptionEvent $event): void
    {
        $message = $event->getThrowable()->getMessage();
        file_put_contents(__DIR__ . '/ec-logs.log', $message, FILE_APPEND);
    }
}