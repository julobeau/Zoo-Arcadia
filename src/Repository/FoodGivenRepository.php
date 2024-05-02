<?php

namespace App\Repository;

use App\Entity\FoodGiven;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FoodGiven>
 *
 * @method FoodGiven|null find($id, $lockMode = null, $lockVersion = null)
 * @method FoodGiven|null findOneBy(array $criteria, array $orderBy = null)
 * @method FoodGiven[]    findAll()
 * @method FoodGiven[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FoodGivenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FoodGiven::class);
    }

    //    /**
    //     * @return FoodGiven[] Returns an array of FoodGiven objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?FoodGiven
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
