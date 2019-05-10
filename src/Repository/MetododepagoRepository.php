<?php

namespace App\Repository;

use App\Entity\Metododepago;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Metododepago|null find($id, $lockMode = null, $lockVersion = null)
 * @method Metododepago|null findOneBy(array $criteria, array $orderBy = null)
 * @method Metododepago[]    findAll()
 * @method Metododepago[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MetododepagoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Metododepago::class);
    }

    // /**
    //  * @return Metododepago[] Returns an array of Metododepago objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Metododepago
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
