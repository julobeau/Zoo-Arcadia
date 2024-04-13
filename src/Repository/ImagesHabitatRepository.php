<?php

namespace App\Repository;

use App\Entity\ImagesHabitat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImagesHabitat>
 *
 * @method ImagesHabitat|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImagesHabitat|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImagesHabitat[]    findAll()
 * @method ImagesHabitat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImagesHabitatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImagesHabitat::class);
    }

    //    /**
    //     * @return ImagesHabitat[] Returns an array of ImagesHabitat objects
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

    //    public function findOneBySomeField($value): ?ImagesHabitat
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
