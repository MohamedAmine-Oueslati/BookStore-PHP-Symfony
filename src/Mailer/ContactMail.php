<?php

namespace App\Mailer;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ContactMail
{

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail($data)
    {
        $email = (new TemplatedEmail())
            ->from(new Address($data["email"], $data["fullname"]))
            ->to(new Address('bookStore@gmail.com', 'BookStore'))
            ->subject($data["subject"])
            ->htmlTemplate('mail.html.twig')
            ->context([
                'type' => 'contact',
                'text' => $data["message"]
            ]);

        $this->mailer->send($email);
    }
}
