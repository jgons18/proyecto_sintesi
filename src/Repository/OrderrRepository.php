<?php

namespace App\Repository;

use App\Entity\Orderr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Orderr|null find($id, $lockMode = null, $lockVersion = null)
 * @method Orderr|null findOneBy(array $criteria, array $orderBy = null)
 * @method Orderr[]    findAll()
 * @method Orderr[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderrRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Orderr::class);
    }

    // /**
    //  * @return Orderr[] Returns an array of Orderr objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Orderr
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
