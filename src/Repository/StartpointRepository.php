<?php

namespace App\Repository;

use App\Entity\Startpoint;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Startpoint|null find($id, $lockMode = null, $lockVersion = null)
 * @method Startpoint|null findOneBy(array $criteria, array $orderBy = null)
 * @method Startpoint[]    findAll()
 * @method Startpoint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StartpointRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Startpoint::class);
    }

    // /**
    //  * @return Startpoint[] Returns an array of Startpoint objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Startpoint
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
