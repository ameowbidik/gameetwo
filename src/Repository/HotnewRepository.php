<?php

namespace App\Repository;

use App\Entity\Hotnew;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Hotnew|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hotnew|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hotnew[]    findAll()
 * @method Hotnew[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HotnewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hotnew::class);
    }

    public function search($criteria)
    {
        $stmt = $this->createQueryBuilder('h');

        if(!empty($criteria['query']))
        {
            $stmt->where('h.title LIKE :query');
            $stmt->setParameter('query', '%' . $criteria['query'] . '%');
        }
        return $stmt->getQuery()->getResult();
    }

    // /**
    //  * @return Hotnew[] Returns an array of Hotnew objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Hotnew
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
