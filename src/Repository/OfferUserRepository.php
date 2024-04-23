<?php

namespace App\Repository;

use App\Entity\OfferUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OfferUser>
 *
 * @method OfferUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method OfferUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method OfferUser[]    findAll()
 * @method OfferUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OfferUser::class);
    }

//    /**
//     * @return OfferUser[] Returns an array of OfferUser objects
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

//    public function findOneBySomeField($value): ?OfferUser
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
