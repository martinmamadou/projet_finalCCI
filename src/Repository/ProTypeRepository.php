<?php

namespace App\Repository;

use App\Entity\ProType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProType>
 *
 * @method ProType|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProType|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProType[]    findAll()
 * @method ProType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProType::class);
    }

    //    /**
    //     * @return ProType[] Returns an array of ProType objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ProType
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
