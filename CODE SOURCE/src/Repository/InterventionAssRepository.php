<?php

namespace App\Repository;

use App\Entity\InterventionAss;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InterventionAss>
 *
 * @method InterventionAss|null find($id, $lockMode = null, $lockVersion = null)
 * @method InterventionAss|null findOneBy(array $criteria, array $orderBy = null)
 * @method InterventionAss[]    findAll()
 * @method InterventionAss[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterventionAssRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InterventionAss::class);
    }

    public function add(InterventionAss $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(InterventionAss $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return InterventionAss[] Returns an array of InterventionAss objects
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

//    public function findOneBySomeField($value): ?InterventionAss
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
