<?php

namespace App\Mailer;

use App\Entity\Users;
use Swift_Mailer;
use Swift_Message;
use Twig\Environment;

class Mailer {
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var array
     */
    private $mailerFrom;
    /**
     * @var Swift_Mailer
     */
    private $mailer;


    public function __construct(Swift_Mailer $mailer, Environment $twig, $mailer_sender_address, $mailer_sender_name) {
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->mailerFrom = [$mailer_sender_address => $mailer_sender_name];
    }

    public function sendRecoveryPasswordEmail(Users $user) {

        $body = $this->twig->render('email/recovery_password.html.twig', [
            'user' => $user
        ]);

        $message = (new Swift_Message());


        $message->setSubject('Link do zmiany hasła')
            ->setFrom($this->mailerFrom)
            ->setTo($user->getEmail())
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }

    public function sendWelcomeEmail(Users $user) {

        $body = $this->twig->render('email/welcome.html.twig', [
            'user' => $user
        ]);

        $message = (new Swift_Message());


        $message->setSubject('Dodane nowe konto w aplikacji DSI-TOOLS')
            ->setFrom($this->mailerFrom)
            ->setTo($user->getEmail())
            ->setBody($body, 'text/html');

        $this->mailer->send($message);
    }
}
