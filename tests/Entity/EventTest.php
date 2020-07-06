<?php

/**
 * EventTest class file
 *
 * PHP Version 7.1
 *
 * @category EventTest
 * @package  EventTest
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

use App\Entity\Event;
use App\Entity\EventCategory;
use App\Entity\Rating;
use App\Entity\User;

use PHPUnit\Framework\TestCase;

/**
 * EventTest class
 *
 * The class holding the root EventTest class definition
 *
 * @category EventTest
 * @package  EventTest
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */
class EventTest extends TestCase
{
    /**
     * Test Event
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function testEvent()
    {
        $now      = new DateTime();
        $event    = new Event();
        $user     = new User();
        $rating   = new Rating();
        $category = new EventCategory();

        $event->setTitle("Title")
            ->setDescription("Description")
            ->setOwner($user)
            ->addCategory($category)
            ->setRating(5)
            ->setStartDate($now)
            ->setEndDate($now)
            ->setPublishDate($now)
            ->addRating($rating);

        $this->assertEquals("Title", $event->getTitle());
        $this->assertEquals("Description", $event->getDescription());
        $this->assertEquals($user, $event->getOwner());
        $this->assertEquals(5, $event->getRating());
        $this->assertEquals($now, $event->getStartDate());
        $this->assertEquals($now, $event->getEndDate());
        $this->assertEquals($now, $event->getPublishDate());

        foreach ($event->getCategories() as $cat) {
            $this->assertEquals($category, $cat);
        }

        $event->removeCategory($category);
        $this->assertEmpty($event->getCategories());

        foreach ($event->getRatings() as $rate) {
            $this->assertEquals($rating, $rate);
        }

        $event->removeRating($rating);
        $this->assertEmpty($event->getRatings());
    }
}