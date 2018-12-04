<?php

namespace App\Repository;

use App\Entity\QuantitySnapshot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method QuantitySnapshot|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuantitySnapshot|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuantitySnapshot[]    findAll()
 * @method QuantitySnapshot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuantitySnapshotRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, QuantitySnapshot::class);
    }

    // /**
    //  * @return QuantitySnapshot[] Returns an array of QuantitySnapshot objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuantitySnapshot
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
