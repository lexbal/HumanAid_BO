<?php

/**
 * Rating class file
 *
 * PHP Version 7.1
 *
 * @category Rating
 * @package  Rating
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Rating class
 *
 * The class holding the root Rating class definition
 *
 * @category                                                      Rating
 * @package                                                       Rating
 * @author                                                        HumanAid <contact.humanaid@gmail.com>
 * @license                                                       http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link                                                          http://example.com/
 * @ORM\Table(name="rating")
 * @ORM\Entity(repositoryClass="App\Repository\RatingRepository")
 */
class Rating
{
    /**
     * ID attribute
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * User attribute
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\User",
     *     inversedBy="ratings"
     * )
     * @ORM\JoinColumn(
     *     name="user_id",
     *     referencedColumnName="id",
     *     onDelete="CASCADE"
     * )
     */
    private $user;

    /**
     * Event attribute
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Event",
     *     inversedBy="ratings"
     * )
     * @ORM\JoinColumn(
     *     name="event_id",
     *     referencedColumnName="id",
     *     onDelete="CASCADE"
     * )
     */
    private $event;

    /**
     * Rating attribute
     *
     * @ORM\Column(type="integer")
     */
    private $rating;

    /**
     * Comment attribute
     *
     * @ORM\Column(type="string", length=255)
     */
    private $comment;

    /**
     * Publish date attribute
     *
     * @ORM\Column(type="datetime")
     */
    private $publish_date;


    /**
     * ID Getter
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * User Getter
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * User Setter
     *
     * @param User|null $user User
     *
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Event Getter
     *
     * @return Event|null
     */
    public function getEvent(): ?Event
    {
        return $this->event;
    }

    /**
     * Event Setter
     *
     * @param Event|null $event Event
     *
     * @return $this
     */
    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Rating Getter
     *
     * @return int|null
     */
    public function getRating(): ?int
    {
        return $this->rating;
    }

    /**
     * Rating Setter
     *
     * @param int $rating Rating
     *
     * @return $this
     */
    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Comment Getter
     *
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Comment Setter
     *
     * @param string $comment Comment
     *
     * @return $this
     */
    public function setComment($comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Publish date Getter
     *
     * @return mixed
     */
    public function getPublishDate()
    {
        return $this->publish_date;
    }

    /**
     * Publish date Setter
     *
     * @param Datetime $publish_date Publish date
     *
     * @return $this
     */
    public function setPublishDate($publish_date): self
    {
        $this->publish_date = $publish_date;

        return $this;
    }
}
