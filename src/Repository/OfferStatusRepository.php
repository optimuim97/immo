<?php

namespace App\Repository;

use App\Entity\OfferStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OfferStatus>
 *
 * @method OfferStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method OfferStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method OfferStatus[]    findAll()
 * @method OfferStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OfferStatus::class);
    }

    //    /**
    //     * @return OfferStatus[] Returns an array of OfferStatus objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('o.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?OfferStatus
    //    {
    //        return $this->createQueryBuilder('o')
    //            ->andWhere('o.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
