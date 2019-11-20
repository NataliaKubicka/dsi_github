<?php


namespace App\EventSubscriber;


use App\Event\UserPasswordRecoveryEvent;
use App\Mailer\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserRecoveryPasswordSubscriber implements EventSubscriberInterface {

    /**
     * @var Mailer
     */
    private $mailer;

    public function __construct(Mailer $mailer) {
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents() {
        return [
            UserPasswordRecoveryEvent::NAME => 'onPasswordRecovery'
        ];
    }


    public function onPasswordRecovery(UserPasswordRecoveryEvent $event) {
        $this->mailer->sendRecoveryPasswordEmail($event->getUser());

    }

}