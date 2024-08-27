<?php

namespace App\Repository;

use App\Entity\Categorie;
use App\Entity\Programme;
use App\Entity\ProType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Programme>
 *
 * @method Programme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Programme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Programme[]    findAll()
 * @method Programme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgrammeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Programme::class);
    }


    public function FindAllByCateg(Categorie $categorie): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.categorie = :categorie')
            ->setParameter('categorie', $categorie)
            ->getQuery()
            ->getResult();
    }

    public function findByProType(ProType $protype): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.protype = :protype')
            ->setParameter('protype', $protype)
            ->getQuery()
            ->getResult();
    }

    public function findAllWithComments()
{
    return $this->createQueryBuilder('p')
        ->join('p.commentaires', 'c') // Joindre les commentaires
        ->groupBy('p.id') // Regrouper par programme
        ->orderBy('p.moyenne', 'DESC') // Trier par la moyenne des notes (descendant)
        ->setMaxResults(10)
        ->getQuery()
        ->getResult();
}

public function findByDate(){
    return $this->createQueryBuilder('p')
    ->orderBy('p.createdAt','DESC')
    ->getQuery()
    ->getResult();
}



    //    /**
    //     * @return Programme[] Returns an array of Programme objects
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

    //    public function findOneBySomeField($value): ?Programme
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
