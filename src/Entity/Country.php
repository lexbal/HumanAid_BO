<?php

/**
 * Country class file
 *
 * PHP Version 7.1
 *
 * @category Country
 * @package  Country
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Country class
 *
 * The class holding the root Country class definition
 *
 * @category Country
 * @package  Country
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="App\Repository\CountryRepository")
 */
class Country
{
    /**
     * ID Attribute
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Code Attribute
     *
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $code;

    /**
     * Label Attribute
     *
     * @ORM\Column(type="string", length=255)
     */
    private $label;

    /**
     * Address attribute
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Address",
     *     mappedBy="country"
     * )
     */
    private $addresses;


    /**
     * Country constructor.
     */
    public function __construct()
    {
        $this->addresses = new ArrayCollection();
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
     * Addresses Getter
     *
     * @return Collection|Address[]
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    /**
     * Addresses Collection Setter
     *
     * @param Address $address Address
     *
     * @return $this
     */
    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->setCountry($this);
        }

        return $this;
    }

    /**
     * Addresses Collection Remover
     *
     * @param Address $address Address
     *
     * @return $this
     */
    public function removeAddress(Address $address): self
    {
        if ($this->addresses->contains($address)) {
            $this->addresses->removeElement($address);
            // set the owning side to null (unless already changed)
            if ($address->getCountry() === $this) {
                $address->setCountry(null);
            }
        }

        return $this;
    }
}
