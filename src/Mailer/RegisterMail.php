<?php

namespace App\Mailer;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

use App\Entity\Users;

class RegisterMail
{

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail(Users $user)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('bookStore@gmail.com', 'BookStore'))
            ->to(new Address($user->getEmail(), $user->getUsername()))
            ->subject('Welcome to bookStore!')
            ->htmlTemplate('welcome.html.twig');
        // ->context([
        //     'user' => $user
        // ]);

        $this->mailer->send($email);
    }
}
