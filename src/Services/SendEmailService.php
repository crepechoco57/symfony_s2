<?php

namespace App\Services;

use App\Entity\User;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class SendEmailService {

    public function __construct(private MailerInterface $mailerInterface, private EmailVerifier $emailVerifier) {}
    public function sendEmail( 
        string $emailVerifier,
        User $user,
        string $from,
        string $to, 
        string $subject,
        string $template,
        array $context =[]
    ):void {
        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("registration/$template.html.twig")
            ->context($context);

            $this->emailVerifier->sendEmailConfirmation(
            'app_verify_email',
            $user,
            $email
            );
        }
}