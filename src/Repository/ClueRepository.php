<?php

namespace App\Repository;

use App\Entity\Clue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Clue|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clue|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clue[]    findAll()
 * @method Clue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Clue::class);
    }

    // /**
    //  * @return Clue[] Returns an array of Clue objects
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
    public function findOneBySomeField($value): ?Clue
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
