<?php

namespace App\Repository;

use App\Entity\ExTemplate;
use App\Entity\Programme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExTemplate>
 *
 * @method ExTemplate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExTemplate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExTemplate[]    findAll()
 * @method ExTemplate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExTemplateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExTemplate::class);
    }

    //    /**
    //     * @return ExTemplate[] Returns an array of ExTemplate objects
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

    //    public function findOneBySomeField($value): ?ExTemplate
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
