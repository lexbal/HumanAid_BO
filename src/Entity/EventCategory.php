<?php

/**
 * EventCategory class file
 *
 * PHP Version 7.1
 *
 * @category EventCategory
 * @package  EventCategory
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * EventCategory class
 *
 * The class holding the root EventCategory class definition
 *
 * @category                                                             EventCategory
 * @package                                                              EventCategory
 * @author                                                               HumanAid <contact.humanaid@gmail.com>
 * @license                                                              http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link                                                                 http://example.com/
 * @ORM\Table(name="event_category")
 * @ORM\Entity(repositoryClass="App\Repository\EventCategoryRepository")
 */
class EventCategory
{
    /**
     * Id attribute
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Code attribute
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code;

    /**
     * Label attribute
     *
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * Event attribute
     *
     * @ORM\ManyToMany(
     *     targetEntity="App\Entity\Event",
     *     inversedBy="categories"
     * )
     */
    private $events;


    /**
     * Event constructor.
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
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
     * Code Getter
     *
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Code Setter
     *
     * @param string|null $code Code
     *
     * @return $this
     */
    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Label Getter
     *
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * Label Setter
     *
     * @param string $label Label
     *
     * @return $this
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Events Getter
     *
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    /**
     * Events Collection Setter
     *
     * @param Event $category Category
     *
     * @return $this
     */
    public function addEvent(Event $category): self
    {
        if (!$this->events->contains($category)) {
            $this->events[] = $category;
            $category->addCategory($this);
        }

        return $this;
    }

    /**
     * Events Collection Remover
     *
     * @param Event $event Event
     *
     * @return $this
     */
    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
        }

        return $this;
    }

    /**
     * ToString function
     *
     * Return Event name if class is called in template
     *
     * @return mixed
     */
    public function __toString()
    {
        return $this->label;
    }
}
