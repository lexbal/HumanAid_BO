<?php

/**
 * Event class file
 *
 * PHP Version 7.1
 *
 * @category Event
 * @package  Event
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event class
 *
 * The class holding the root Event class definition
 *
 * @category                                                     Event
 * @package                                                      Event
 * @author                                                       HumanAid <contact.humanaid@gmail.com>
 * @license                                                      http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link                                                         http://example.com/
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
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
     * Title attribute
     *
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * Description attribute
     *
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * User attribute
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\User",
     *     inversedBy="events"
     * )
     * @ORM\JoinColumn(
     *     name="owner_id",
     *     referencedColumnName="id",
     *     onDelete="CASCADE"
     * )
     */
    private $owner;

    /**
     * Category attribute
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\EventCategory",
     *     mappedBy="events"
     * )
     */
    private $categories;

    /**
     * Start date attribute
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $start_date;

    /**
     * End date attribute
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $end_date;

    /**
     * Publish date attribute
     *
     * @ORM\Column(type="datetime")
     */
    private $publish_date;

    /**
     * Rating attribute
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Rating", mappedBy="event")
     */
    private $ratings;

    /**
     * Rating attribute
     *
     * @ORM\Column(type="float", nullable=true)
     */
    private $rating;

    /**
     * Event constructor.
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->ratings = new ArrayCollection();
    }

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
     * Title Getter
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Title Setter
     *
     * @param string $title Title
     *
     * @return Event
     */
    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Description Getter
     *
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Description Setter
     *
     * @param string $description Description
     *
     * @return Event
     */
    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * User Getter
     *
     * @return mixed
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * User Setter
     *
     * @param User $owner owner
     *
     * @return Event
     */
    public function setOwner($owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Categories Getter
     *
     * @return Collection|EventCategory[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * Categories Collection Setter
     *
     * @param EventCategory $category Category
     *
     * @return $this
     */
    public function addCategory(EventCategory $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addEvent($this);
        }

        return $this;
    }

    /**
     * Categories Collection Remover
     *
     * @param EventCategory $category Category
     *
     * @return $this
     */
    public function removeCategory(EventCategory $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
        }

        return $this;
    }

    /**
     * Start date Getter
     *
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * Start date Setter
     *
     * @param Datetime $start_date Start date
     *
     * @return Event
     */
    public function setStartDate($start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    /**
     * End date Getter
     *
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * End date Setter
     *
     * @param DateTime $end_date End date
     *
     * @return Event
     */
    public function setEndDate($end_date): self
    {
        $this->end_date = $end_date;

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
     * @param DateTime $publish_date Publish date
     *
     * @return Event
     */
    public function setPublishDate($publish_date): self
    {
        $this->publish_date = $publish_date;

        return $this;
    }

    /**
     * Ratings Getter
     *
     * @return Collection
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    /**
     * Ratings Adder
     *
     * @param Rating $rating Rating
     *
     * @return $this
     */
    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setEvent($this);
        }

        return $this;
    }

    /**
     * Ratings Remover
     *
     * @param Rating $rating Rating
     *
     * @return $this
     */
    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->contains($rating)) {
            $this->ratings->removeElement($rating);
            // set the owning side to null (unless already changed)
            if ($rating->getEvent() === $this) {
                $rating->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * Rating Getter
     *
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Rating Setter
     *
     * @param int $rating Rating
     *
     * @return Event
     */
    public function setRating($rating): self
    {
        $this->rating = $rating;

        return $this;
    }
}
