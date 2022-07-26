<?php

namespace App\Repository;

use App\Entity\Rapport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rapport>
 *
 * @method Rapport|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rapport|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rapport[]    findAll()
 * @method Rapport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RapportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rapport::class);
    }

    public function add(Rapport $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Rapport $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function ListeRapportsNonSupprimés(){
        return $this->createQueryBuilder('r')
        ->andWhere('r.Enable=True')
        ->getQuery()
        ->getResult();
    }

    public function ListeRapportsLue()
    {
        return $this->createQueryBuilder('r')
            ->andWhere("r.StatutRapport='Lu'")
            ->getQuery()
            ->getResult()
        ;
    }

    public function ListeRapportsNonLue()
    {
        return $this->createQueryBuilder('r')
            ->andWhere("r.StatutRapport='NonLu'")
            ->getQuery()
            ->getResult()
        ;
    }

    public function ListeRapportsSupprimés(){
        return $this->createQueryBuilder('r')
        ->andWhere('r.Enable=False')
        ->getQuery()
        ->getResult();
    }

//    /**
//     * @return Rapport[] Returns an array of Rapport objects
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

//    public function findOneBySomeField($value): ?Rapport
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
