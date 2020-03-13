<?php

use App\Entity\Event;
use App\Entity\Rating;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    public function testEvent()
    {
        $now    = new DateTime();
        $event  = new Event();
        $user   = new User();
        $rating = new Rating();

        $rating->setRating(5)
               ->setComment("Com")
               ->setEvent($event)
               ->setUser($user)
               ->setPublishDate($now);

        $event->setTitle("Title")
              ->setDescription("Description")
              ->setOwner($user)
              ->setRating(5)
              ->setStartDate($now)
              ->setEndDate($now)
              ->setPublishDate($now)
              ->addRating($rating);

        $this->assertSame("Title", $event->getTitle());
        $this->assertSame("Description", $event->getDescription());
        $this->assertSame($user, $event->getOwner());
        $this->assertSame(5, $event->getRating());
        $this->assertSame($now, $event->getStartDate());
        $this->assertSame($now, $event->getEndDate());
        $this->assertSame($now, $event->getPublishDate());

        foreach ($event->getRatings() as $rate) {
            $this->assertSame(5, $rate->getRating());
            $this->assertSame("Com", $rate->getComment());
            $this->assertSame($event, $rate->getEvent());
            $this->assertSame($user, $rate->getUser());
            $this->assertSame($now, $rate->getPublishDate());
        }

        $event->removeRating($rating);
        $this->assertEmpty($event->getRatings());
    }
}