<?php

namespace App\Repository;

use App\Entity\AssistantAuto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AssistantAuto>
 *
 * @method AssistantAuto|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssistantAuto|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssistantAuto[]    findAll()
 * @method AssistantAuto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssistantAutoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssistantAuto::class);
    }

    public function add(AssistantAuto $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AssistantAuto $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AssistantAuto[] Returns an array of AssistantAuto objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AssistantAuto
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
