<?php

namespace App\Repository;

use App\Entity\InfoProgramme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InfoProgramme>
 *
 * @method InfoProgramme|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfoProgramme|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfoProgramme[]    findAll()
 * @method InfoProgramme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoProgrammeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfoProgramme::class);
    }

    //    /**
    //     * @return InfoProgramme[] Returns an array of InfoProgramme objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('i.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?InfoProgramme
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
