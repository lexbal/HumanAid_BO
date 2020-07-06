<?php

/**
 * RatingTest class file
 *
 * PHP Version 7.1
 *
 * @category RatingTest
 * @package  RatingTest
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Tests\Entity;

use App\Entity\Address;
use App\Entity\Country;
use App\Entity\Event;
use App\Entity\Rating;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * RatingTest class
 *
 * The class holding the root RatingTest class definition
 *
 * @category RatingTest
 * @package  RatingTest
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */
class RatingTest extends TestCase
{
    /**
     * Test Address
     *
     * @return mixed
     */
    public function testRating()
    {
        $rating = new Rating();
        $user   = new User();
        $event  = new Event();

        $rating->setUser($user)
            ->setEvent($event)
            ->setComment("test")
            ->setRating(5);

        $this->assertEquals($rating->getUser(), $user);
        $this->assertEquals($rating->getEvent(), $event);
        $this->assertEquals($rating->getComment(), "test");
        $this->assertEquals($rating->getRating(), 5);
    }
}
