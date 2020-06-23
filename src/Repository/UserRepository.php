<?php

/**
 * UserRepository class file
 *
 * PHP Version 7.1
 *
 * @category UserRepository
 * @package  UserRepository
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * UserRepository class
 *
 * The class holding the root UserRepository class definition
 *
 * @category UserRepository
 * @package  UserRepository
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * UserRepository constructor.
     *
     * @param ManagerRegistry $registry manage repository registration
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function countUsersTotal()
    {
        return $this->createQueryBuilder('u')
            ->select('count(u.id) AS total')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countUsers()
    {
        return $this->createQueryBuilder('u')
            ->select('sum(IF(u.roles LIKE \'%ASSOC%\', 1, 0)) AS associations, sum(IF(u.roles LIKE \'%COMP%\', 1, 0)) AS companies, sum(IF(u.roles LIKE \'%USER%\', 1, 0)) AS users')
            ->getQuery()
            ->getResult()[0];
    }

    public function chart()
    {
        return $this->createQueryBuilder('u')
            ->select('DATE_FORMAT(u.created_at, \'%Y-%m-%d\') as date, sum(IF(u.roles LIKE \'%ASSOC%\', 1, 0)) AS assoc, sum(IF(u.roles LIKE \'%COMP%\', 1, 0)) AS company, sum(IF(u.roles LIKE \'%USER%\', 1, 0)) AS user')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
