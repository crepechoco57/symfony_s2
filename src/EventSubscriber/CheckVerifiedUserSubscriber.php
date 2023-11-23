<?php

namespace App\EventSubscriber;

use Symfony\Component\Security\Http\Event\CheckPassportEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use App\Entity\User;

class CheckVerifiedUserSubscriber implements EventSubscriberInterface
{
    public function onCheckPassportEvent(CheckPassportEvent $event): void
    {
       $passport = $event->getPassport();
       $user = $passport->getUser();
       if (!$user instanceof User){
        throw new \Exception('Utilisateur inconnu');
       }
    //    if (!$user->isVerified()){
    //     throw new AuthenticationException();
    //    }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CheckPassportEvent::class => ['onCheckPassportEvent',10],
        ];
    }
}
