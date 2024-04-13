<?php

namespace App\Repository;

use App\Entity\ImagesAnimal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImagesAnimal>
 *
 * @method ImagesAnimal|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImagesAnimal|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImagesAnimal[]    findAll()
 * @method ImagesAnimal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImagesAnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImagesAnimal::class);
    }

//    /**
//     * @return ImagesAnimal[] Returns an array of ImagesAnimal objects
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

//    public function findOneBySomeField($value): ?ImagesAnimal
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
