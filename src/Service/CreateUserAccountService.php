<?php


namespace App\Service;


use App\Entity\Users;
use App\Utils\Token;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class CreateUserAccountService
{

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Users
     */
    private $users;

    private $password;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(Users $users, EntityManager $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->users = $users;
        $this->password = Token::generateToken(14);
        $this->passwordEncoder = $passwordEncoder;
    }

    public function createUser(): void
    {
        $password = $this->getGeneratePassword();

        $password = $this->passwordEncoder->encodePassword(
            $this->users,
            $password
        );

        $this->users->setPassword($password);
        $this->users->setPasswordRequestToken(Token::generateToken(14));

        $this->entityManager->persist($this->users);
        $this->entityManager->flush();
    }

    // Generate password
    public function getGeneratePassword() {
        return $this->password;
    }

}
