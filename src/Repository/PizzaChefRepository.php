<?php

namespace App\Repository;

use App\Entity\PizzaChef;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PizzaChef|null find($id, $lockMode = null, $lockVersion = null)
 * @method PizzaChef|null findOneBy(array $criteria, array $orderBy = null)
 * @method PizzaChef[]    findAll()
 * @method PizzaChef[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PizzaChefRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PizzaChef::class);
    }

    // /**
    //  * @return PizzaChef[] Returns an array of PizzaChef objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PizzaChef
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
