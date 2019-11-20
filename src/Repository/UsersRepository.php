<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Users::class);
    }

    public function findUserByEmail(string $email) {
        $qb = $this->createQueryBuilder('user');

        return $qb->select('user')
            ->setParameter('email', $email)
            ->where('user.email = :email')
            ->distinct(true)
            ->getQuery()
            ->getOneOrNullResult();

    }

    public function findPasswordToken(string $token) {
        $qb = $this->createQueryBuilder('user');

        return $qb->select('user')
            ->setParameter('token', $token)
            ->where('user.passwordRequestToken = :token')
            ->getQuery()
            ->getOneOrNullResult();

    }
}
