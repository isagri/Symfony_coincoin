<?php

namespace App\Repository;

use App\Entity\Advertisment;
use App\Entity\Region;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Advertisment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advertisment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advertisment[]    findAll()
 * @method Advertisment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvertismentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Advertisment::class);
    }

    /**
     * @return Advertisment[] Returns an array of Advertisment objects
     */

    public function searchByTitle($title)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.title like :searchTitle')
            ->setParameter('searchTitle', '%'.$title."%")
            ->orderBy('a.creationDate', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function searchByRegion(Region $region)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.region = :region')
            ->setParameter('region', $region)
            ->orderBy('a.creationDate', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function searchByRegionTitle(Region $region, $title)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.region = :region and a.title like :searchTitle')
            ->setParameter('region', $region)
            ->setParameter('searchTitle', '%'.$title."%")
            ->orderBy('a.creationDate', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }



//    /**
//     * @return Advertisment[] Returns an array of Advertisment objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Advertisment
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
