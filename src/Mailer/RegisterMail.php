<?php

namespace App\Mailer;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

use App\Entity\User;

class RegisterMail
{

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail(User $user)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('bookStore@gmail.com', 'BookStore'))
            ->to(new Address($user->getEmail(), $user->getUsername()))
            ->subject('Welcome to bookStore!')
            ->htmlTemplate('mail.html.twig')
            ->context([
                'type' => 'register'
            ]);

        $this->mailer->send($email);
    }
}
