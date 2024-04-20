<?php

namespace App\Repository;

use App\Entity\ExerciceMaison;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExerciceMaison>
 *
 * @method ExerciceMaison|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExerciceMaison|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExerciceMaison[]    findAll()
 * @method ExerciceMaison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExerciceMaisonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExerciceMaison::class);
    }

    //    /**
    //     * @return ExerciceMaison[] Returns an array of ExerciceMaison objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ExerciceMaison
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
