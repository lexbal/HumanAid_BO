<?php

/**
 * EventRepository class file
 *
 * PHP Version 7.1
 *
 * @category EventRepository
 * @package  EventRepository
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * EventRepository class
 *
 * The class holding the root EventRepository class definition
 *
 * @category EventRepository
 * @package  EventRepository
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */
class EventRepository extends ServiceEntityRepository
{
    /**
     * EventRepository constructor.
     *
     * @param ManagerRegistry $registry manage repository registration
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function countEvents()
    {
        return $this->createQueryBuilder('e')
            ->select('count(e.id) AS total')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findPastEvents()
    {
        return $this->createQueryBuilder('e')
            ->select('count(e.id) AS total')
            ->where('e.end_date < CURRENT_DATE()')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findCurrentEvents()
    {
        return $this->createQueryBuilder('e')
            ->select('count(e.id) AS total')
            ->where('CURRENT_DATE() BETWEEN e.start_date AND e.end_date')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findFutureEvents()
    {
        return $this->createQueryBuilder('e')
            ->select('count(e.id) AS total')
            ->where('e.start_date > CURRENT_DATE()')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function chart()
    {
        return $this->createQueryBuilder('e')
            ->select('DATE_FORMAT(e.publish_date, \'%Y-%m-%d\') as date, count(e.id) AS total')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Event[] Returns an array of Event objects
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
    public function findOneBySomeField($value): ?Event
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
