<?php

/**
 * CountryRepository class file
 *
 * PHP Version 7.1
 *
 * @category CountryRepository
 * @package  CountryRepository
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Repository;

use App\Entity\Country;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * CountryRepository class
 *
 * The class holding the root CountryRepository class definition
 *
 * @category CountryRepository
 * @package  CountryRepository
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */
class CountryRepository extends ServiceEntityRepository
{
    /**
     * CountryRepository constructor.
     *
     * @param ManagerRegistry $registry manage repository registration
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Country::class);
    }

    // /**
    //  * @return Country[] Returns an array of Country objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Country
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
