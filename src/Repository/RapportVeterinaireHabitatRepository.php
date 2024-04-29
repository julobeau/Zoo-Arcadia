<?php

namespace App\Repository;

use App\Entity\RapportVeterinaireHabitat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RapportVeterinaireHabitat>
 *
 * @method RapportVeterinaireHabitat|null find($id, $lockMode = null, $lockVersion = null)
 * @method RapportVeterinaireHabitat|null findOneBy(array $criteria, array $orderBy = null)
 * @method RapportVeterinaireHabitat[]    findAll()
 * @method RapportVeterinaireHabitat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportVeterinaireHabitatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RapportVeterinaireHabitat::class);
    }

    //    /**
    //     * @return RapportVeterinaireHabitat[] Returns an array of RapportVeterinaireHabitat objects
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

    //    public function findOneBySomeField($value): ?RapportVeterinaireHabitat
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findAllOrderByDate(): ?array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM app\Entity\RapportVeterinaireHabitat p
            ORDER BY p.createdAt DESC'
        );
        return $query->getResult();
    }

}
