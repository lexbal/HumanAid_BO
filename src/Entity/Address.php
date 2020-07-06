<?php

/**
 * Address class file
 *
 * PHP Version 7.1
 *
 * @category Address
 * @package  Address
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Address class
 *
 * The class holding the root Address class definition
 *
 * @category Address
 * @package  Address
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 */
class Address
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
     * User Attribute
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\User",
     *     inversedBy="addresses",
     *     cascade={"persist"}
     * )
     */
    private $user;

    /**
     * Street Attribute
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $street;

    /**
     * ZipCode Attribute
     *
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $zipcode;

    /**
     * City Attribute
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * Region Attribute
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $region;

    /**
     * Department Attribute
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $department;

    /**
     * Country Attribute
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Country"
     * )
     * @ORM\JoinColumn(
     *     name="country_id",
     *     referencedColumnName="id",
     *     onDelete="CASCADE"
     * )
     */
    private $country;


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
     * Street Getter
     *
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * Street Setter
     *
     * @param string|null $street Street
     *
     * @return $this
     */
    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    /**
     * City Getter
     *
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * City Setter
     *
     * @param string|null $city City
     *
     * @return $this
     */
    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * ZipCode Getter
     *
     * @return string|null
     */
    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    /**
     * ZipCode Setter
     *
     * @param string|null $zipcode Zipcode
     *
     * @return $this
     */
    public function setZipcode(?string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Region Getter
     *
     * @return string|null
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * Region Setter
     *
     * @param string|null $region Region
     *
     * @return $this
     */
    public function setRegion(?string $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Department Getter
     *
     * @return string|null
     */
    public function getDepartment(): ?string
    {
        return $this->department;
    }

    /**
     * Department Setter
     *
     * @param string|null $department Department
     *
     * @return $this
     */
    public function setDepartment(?string $department): self
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Country Getter
     *
     * @return Country|null
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    /**
     * Country Setter
     *
     * @param Country|null $country Country
     *
     * @return $this
     */
    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * ToString function
     *
     * @return string
     */
    public function __toString()
    {
        return $this->street . ", " . $this->zipcode . " " . $this->city;
    }
}
