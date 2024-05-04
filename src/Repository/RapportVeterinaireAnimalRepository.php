<?php

namespace App\Repository;

use App\Entity\RapportVeterinaireAnimal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RapportVeterinaireAnimal>
 *
 * @method RapportVeterinaireAnimal|null find($id, $lockMode = null, $lockVersion = null)
 * @method RapportVeterinaireAnimal|null findOneBy(array $criteria, array $orderBy = null)
 * @method RapportVeterinaireAnimal[]    findAll()
 * @method RapportVeterinaireAnimal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportVeterinaireAnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RapportVeterinaireAnimal::class);
    }

    //    /**
    //     * @return RapportVeterinaireAnimal[] Returns an array of RapportVeterinaireAnimal objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?RapportVeterinaireAnimal
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    /**
     * Return all reports  ordered by date desc
     *
     * @return array|null
     */
    public function findAllOrderByDate(): ?array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM app\Entity\RapportVeterinaireAnimal p
            ORDER BY p.date DESC'
        );
        return $query->getResult();
    }
}
