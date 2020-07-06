<?php

/**
 * EventCategoryTest class file
 *
 * PHP Version 7.1
 *
 * @category EventCategoryTest
 * @package  EventCategoryTest
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
 * EventCategoryTest class
 *
 * The class holding the root EventCategoryTest class definition
 *
 * @category EventCategoryTest
 * @package  EventCategoryTest
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */
class EventCategoryTest extends TestCase
{
    /**
     * Test EventCategory
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function testEventCategory()
    {
        $now      = new DateTime();
        $event    = new Event();
        $category = new EventCategory();

        $category->setCode("cc")
            ->setLabel("Concert")
            ->addEvent($event);

        $this->assertEquals("cc", $category->getCode());
        $this->assertEquals("Concert", $category->getLabel());

        foreach ($category->getEvents() as $ev) {
            $this->assertEquals($event, $ev);
        }

        $category->removeEvent($event);
        $this->assertEmpty($category->getEvents());
    }
}