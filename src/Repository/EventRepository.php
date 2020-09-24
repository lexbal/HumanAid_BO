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
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

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

    /**
     * Get events
     *
     * @return mixed
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function countEvents()
    {
        return $this->createQueryBuilder('e')
            ->select('count(e.id) AS total')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Get past events
     *
     * @return mixed
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findPastEvents()
    {
        return $this->createQueryBuilder('e')
            ->select('count(e.id) AS total')
            ->where('e.end_date < CURRENT_DATE()')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Get current events
     *
     * @return mixed
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findCurrentEvents()
    {
        return $this->createQueryBuilder('e')
            ->select('count(e.id) AS total')
            ->where('CURRENT_DATE() BETWEEN e.start_date AND e.end_date')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Get future events
     *
     * @return mixed
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function findFutureEvents()
    {
        return $this->createQueryBuilder('e')
            ->select('count(e.id) AS total')
            ->where('e.start_date > CURRENT_DATE()')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Get chart data
     *
     * @return mixed
     */
    public function chart()
    {
        return $this->createQueryBuilder('e')
            ->select('DATE_FORMAT(e.publish_date, \'%Y-%m-%d\') as date')
            ->addSelect('count(e.id) AS total')
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
