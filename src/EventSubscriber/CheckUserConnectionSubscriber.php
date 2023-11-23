<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;

class CheckUserConnectionSubscriber implements EventSubscriberInterface
{
    public function __construct(private LoggerInterface $logger){}

    public function onSecurityAuthenticationSuccess(AuthenticationSuccessEvent $event) :void{
    $this->logger->info('test de connexion = ok');
    $token = $event->getAuthenticationToken();
    $this->logger->info('Le token : ' .$token);
    // dd($token);
    $user = $token->getUser();
    // dd($user);
    $email = $user->getEmail();
    // dd($email);
    $this->logger->info('Email' .$email);

    }
    // public function onLoginSuccessEvent(LoginSuccessEvent $event): void
    // {
    //     dd($event);
    // }
    public static function getSubscribedEvents(): array
    {
        return [
            'security.authentication.success'=> 'onSecurityAuthenticationSuccess',
            // LoginSuccessEvent::class => 'onLoginSuccessEvent',
        ];
    }
}
