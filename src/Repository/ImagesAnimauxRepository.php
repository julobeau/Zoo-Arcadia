<?php

namespace App\Repository;

use App\Entity\ImagesAnimaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImagesAnimaux>
 *
 * @method ImagesAnimaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImagesAnimaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImagesAnimaux[]    findAll()
 * @method ImagesAnimaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImagesAnimauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImagesAnimaux::class);
    }

    //    /**
    //     * @return ImagesAnimaux[] Returns an array of ImagesAnimaux objects
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

    //    public function findOneBySomeField($value): ?ImagesAnimaux
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
