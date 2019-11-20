<?php


namespace App\Event;


use App\Entity\Users;
use Symfony\Component\EventDispatcher\Event;

class UserPasswordRecoveryEvent extends Event {

    const NAME = 'user.password_recovery';
    /**
     * @var Users
     */
    private $user;

    public function __construct(Users $user) {

        $this->user = $user;
    }

    public function getUser(): Users {
        return $this->user;
    }

}