<?php

namespace App\Repository;

use App\Entity\Subscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Subscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method Subscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method Subscription[]    findAll()
 * @method Subscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subscription::class);
    }

    public function getSubcription($member, $lesson, $createdAt, $finishedAt)
    {
        return $this->createQueryBuilder('s')
            ->join('s.member', 'm')
            ->join('s.lessons', 'l')
            ->where('m = :val')
            ->andWhere('l = :val1')
            ->andWhere('(:cdate BETWEEN s.createdAt AND s.finishedAt) OR (:fdate BETWEEN s.createdAt AND s.finishedAt)')
            ->setParameter(':val', $member)
            ->setParameter(':val1', $lesson)
            ->setParameter(':cdate', $createdAt)
            ->setParameter(':fdate', $finishedAt)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Subscription
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
