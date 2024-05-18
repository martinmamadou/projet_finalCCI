<?php

namespace App\Repository;

use App\Entity\Exercices;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Exercices>
 *
 * @method Exercices|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exercices|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exercices[]    findAll()
 * @method Exercices[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExercicesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercices::class);
    }

    public function findDistinctFirstOccurrences()
    {
        $subQuery = $this->createQueryBuilder('sub')
        ->select('MIN(sub.id)')
        ->groupBy('sub.name')
        ->getQuery()
        ->getScalarResult();

    // Extraire les valeurs d'ID minimaux de la sous-requête
    $minIds = array_column($subQuery, 1);

    // Récupérer les premières instances de chaque exercice en utilisant les ID minimaux
    $qb = $this->createQueryBuilder('e');
    $qb->where($qb->expr()->in('e.id', $minIds));

    return $qb->getQuery()->getResult();
    }
    //    /**
    //     * @return Exercices[] Returns an array of Exercices objects
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

    //    public function findOneBySomeField($value): ?Exercices
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
