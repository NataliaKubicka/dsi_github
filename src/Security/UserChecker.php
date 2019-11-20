<?php


namespace App\Security;


use App\Entity\Users;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface{


    private const LOGIN_ERROR_MESSAGE = "Nie możesz zalogować się do aplikacji. Skontaktuj się z administratorem";
    /**
     * Checks the user account before authentication.
     *
     * @throws AccountStatusException
     */
    public function checkPreAuth(UserInterface $user) {
        if (!$user instanceof Users) {
            return;
        }

        if (!$user->getIsActive()) {
            throw new CustomUserMessageAuthenticationException(
                self::LOGIN_ERROR_MESSAGE
            );
        }

    }

    /**
     * Checks the user account after authentication.
     *
     * @throws AccountStatusException
     */
    public function checkPostAuth(UserInterface $user) {
        // TODO: Implement checkPostAuth() method.
    }
}