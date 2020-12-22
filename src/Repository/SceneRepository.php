<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\Scene;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Scene|null find($id, $lockMode = null, $lockVersion = null)
 * @method Scene|null findOneBy(array $criteria, array $orderBy = null)
 * @method Scene[]    findAll()
 * @method Scene[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SceneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Scene::class);
    }

    // /**
    //  * @return Scene[] Returns an array of Scene objects
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
    public function findOneBySomeField($value): ?Scene
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function findNextPosition(Game $game)
    {
       $gameScene = $this->findBy(
           ['game' => $game],
           ['position' => 'DESC']);

       if (!$gameScene || count($gameScene) == 0) {
           return 1;
       }

       return $gameScene[0]->getPosition()+1;
    }

    public function findBetweenPositions(int $startPosition, int $endPosition) {

        if ($startPosition > $endPosition) {
            $buffer = $startPosition;
            $startPosition = $endPosition;
            $endPosition = $buffer;
        }

        return $this->createQueryBuilder('s')
            ->andWhere('s.position >= :startPosition')
            ->setParameter('startPosition', $startPosition)
            ->andWhere('s.position <= :endPosition')
            ->setParameter('endPosition', $endPosition)
            ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
