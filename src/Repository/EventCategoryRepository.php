<?php

/**
 * EventCategoryRepository class file
 *
 * PHP Version 7.1
 *
 * @category EventCategoryRepository
 * @package  EventCategoryRepository
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Repository;

use App\Entity\EventCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * EventCategoryRepository class
 *
 * The class holding the root EventCategoryRepository class definition
 *
 * @category EventCategoryRepository
 * @package  EventCategoryRepository
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */
class EventCategoryRepository extends ServiceEntityRepository
{
    /**
     * EventCategoryRepository constructor.
     *
     * @param ManagerRegistry $registry manage repository registration
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventCategory::class);
    }

    // /**
    //  * @return EventCategory[] Returns an array of EventCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EventCategory
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
