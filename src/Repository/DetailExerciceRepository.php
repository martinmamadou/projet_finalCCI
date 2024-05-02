<?php

namespace App\Repository;

use App\Entity\DetailExercice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DetailExercice>
 *
 * @method DetailExercice|null find($id, $lockMode = null, $lockVersion = null)
 * @method DetailExercice|null findOneBy(array $criteria, array $orderBy = null)
 * @method DetailExercice[]    findAll()
 * @method DetailExercice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DetailExerciceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DetailExercice::class);
    }

    //    /**
    //     * @return DetailExercice[] Returns an array of DetailExercice objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?DetailExercice
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
