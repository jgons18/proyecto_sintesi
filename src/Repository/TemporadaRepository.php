<?php

namespace App\Repository;

use App\Entity\Temporada;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Temporada|null find($id, $lockMode = null, $lockVersion = null)
 * @method Temporada|null findOneBy(array $criteria, array $orderBy = null)
 * @method Temporada[]    findAll()
 * @method Temporada[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemporadaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Temporada::class);
    }

    // /**
    //  * @return Temporada[] Returns an array of Temporada objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Temporada
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
