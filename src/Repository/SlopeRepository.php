<?php

namespace App\Repository;

use App\Entity\Slope;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Slope|null find($id, $lockMode = null, $lockVersion = null)
 * @method Slope|null findOneBy(array $criteria, array $orderBy = null)
 * @method Slope[]    findAll()
 * @method Slope[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SlopeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Slope::class);
    }

    public function findByNameOrCity(string $value): array
    {
        return $this->createQueryBuilder('q')
            ->where('UPPER(q.name) LIKE UPPER(:phrase)')
            ->orWhere('UPPER(q.city) LIKE UPPER(:phrase)')
            ->setParameter('phrase', '%'.$value.'%')
            ->getQuery()
            ->execute();
    }

    // /**
    //  * @return Slope[] Returns an array of Slope objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Slope
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
