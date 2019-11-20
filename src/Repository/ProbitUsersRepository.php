<?php

namespace App\Repository;

use App\Entity\ProbitUsers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProbitUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProbitUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProbitUsers[]    findAll()
 * @method ProbitUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProbitUsersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProbitUsers::class);
    }

    // /**
    //  * @return ProbitUsers[] Returns an array of ProbitUsers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProbitUsers
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
