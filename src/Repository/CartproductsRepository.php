<?php

namespace App\Repository;

use App\Entity\Cartproducts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cartproducts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cartproducts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cartproducts[]    findAll()
 * @method Cartproducts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartproductsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cartproducts::class);
    }

    // /**
    //  * @return Cartproducts[] Returns an array of Cartproducts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cartproducts
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
