<?php


namespace App\Service;


use App\Entity\Users;
use App\Event\UserPasswordRecoveryEvent;
use App\Repository\UsersRepository;
use App\Utils\Messages;
use App\Utils\Token;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService {

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UsersRepository
     */
    private $usersRepository;
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    public function __construct(EntityManagerInterface $entityManager, UsersRepository $usersRepository,
                                EventDispatcherInterface $dispatcher, UserPasswordEncoderInterface $passwordEncoder,
                                FlashBagInterface $flashBag) {

        $this->entityManager = $entityManager;
        $this->usersRepository = $usersRepository;
        $this->dispatcher = $dispatcher;
        $this->passwordEncoder = $passwordEncoder;
        $this->flashBag = $flashBag;
    }

    public function userCreateAccount()
    {

    }

    public function sendPasswordRecoveryEmail(FormInterface $form) {
        $user = $this->getUserByEmail($form);
        if ($user instanceof Users) {
            $this->sendEmail($user);
            return $this->flashBag->set('success', Messages::EMAIL_SEND);
        } else {
            return $this->flashBag->set('danger', Messages::USER_NOT_FOUND);
        }
    }



    private function sendEmail(Users $user) {
        $this->generateToken($user);
        $this->triggerRecoveryPassword($user);
    }

    private function triggerRecoveryPassword($user) {
        $recoveryPasswordEvent = new UserPasswordRecoveryEvent($user);
        $this->dispatcher->dispatch(UserPasswordRecoveryEvent::NAME, $recoveryPasswordEvent);
    }

    public function setNewPassword(Users $user, FormInterface $form) {
        $plainPassword = $form->get('plainPassword')->getData();
        $password = $this->passwordEncoder->encodePassword($user, $plainPassword);
        $user->setPassword($password);
        $user->setPasswordRequestToken(null);
        $this->entityManager->flush();
    }

    private function generateToken(Users $user) {
        $token = Token::generateToken(32);
        $user->setPasswordRequestToken($token);
        $this->entityManager->flush();
    }

    public function getUserByEmail(FormInterface $form): ?Users {
        $email = $form->get('email')->getData();
        return $this->usersRepository->findUserByEmail($email);
    }

    public function getUserByToken(string $token): ?Users {
        return $this->usersRepository->findPasswordToken($token);
    }

}
