<?php

/**
 * User class file
 *
 * PHP Version 7.1
 *
 * @category User
 * @package  User
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User class
 *
 * The class holding the root User class definition
 *
 * @category                                                    User
 * @package                                                     User
 * @author                                                      HumanAid <contact.humanaid@gmail.com>
 * @license                                                     http://opensource.org/licenses/gpl-license.php GPL
 * @link                                                        http://example.com/
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    const ROLE_ADMIN = "ROLE_ADMIN";
    const ROLE_USER  = "ROLE_USER";
    const ROLE_COMP  = "ROLE_COMP";
    const ROLE_ASSOC = "ROLE_ASSOC";

    public static $roleTypes = [
        self::ROLE_ADMIN,
        self::ROLE_USER,
        self::ROLE_COMP,
        self::ROLE_ASSOC
    ];

    /**
     * ID attribute
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Name attribute
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * Manager first name attribute
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $manager_first_name;

    /**
     * Manager last name attribute
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $manager_last_name;

    /**
     * Username attribute
     *
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * Description attribute
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * Photo attribute
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * Status attribute
     *
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * Siret attribute
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $siret;

    /**
     * Landline attribute
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $landline;

    /**
     * Address attribute
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Address",
     *     mappedBy="user"
     * )
     */
    private $addresses;

    /**
     * Website attribute
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * Email attribute
     *
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * Roles attribute
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * Password attribute
     *
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * Facebook link attribute
     *
     * @ORM\Column(type="string", length=255)
     */
    private $facebook;

    /**
     * Twitter attribute
     *
     * @ORM\Column(type="string", length=255)
     */
    private $twitter;

    /**
     * Creation date attribute
     *
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * Update date attribute
     *
     * @ORM\Column(type="datetime")
     */
    private $updated_at;


    /**
     * User constructor.
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
     * Manager First name Getter
     *
     * @return mixed
     */
    public function getManagerFirstName()
    {
        return $this->manager_first_name;
    }

    /**
     * Manager First name Setter
     *
     * @param mixed $manager_first_name Manager First name
     *
     * @return User
     */
    public function setManagerFirstName($manager_first_name): self
    {
        $this->manager_first_name = $manager_first_name;

        return $this;
    }

    /**
     * Manager Last name Getter
     *
     * @return mixed
     */
    public function getManagerLastName()
    {
        return $this->manager_last_name;
    }

    /**
     * Manager Last name Setter
     *
     * @param mixed $manager_last_name Manager Last name
     *
     * @return User
     */
    public function setManagerLastName($manager_last_name): self
    {
        $this->manager_last_name = $manager_last_name;

        return $this;
    }

    /**
     * Name Getter
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Name Setter
     *
     * @param string $name Name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Username Getter
     *
     * @return string|null
     */
    public function getUserName(): ?string
    {
        return $this->username;
    }

    /**
     * Username Setter
     *
     * @param string $username Username
     *
     * @return $this
     */
    public function setUserName(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Description Getter
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Description Setter
     *
     * @param string $description Description
     *
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Status Getter
     *
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Status Setter
     *
     * @param string $status Status
     *
     * @return $this
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

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
            $address->setUser($this);
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
            if ($address->getUser() === $this) {
                $address->setUser(null);
            }
        }

        return $this;
    }

    /**
     * Website Getter
     *
     * @return string|null
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * Website Setter
     *
     * @param string $website Website
     *
     * @return $this
     */
    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Email Getter
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Email Setter
     *
     * @param string $email Email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Roles Getter
     *
     * @return array|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * Roles Setter
     *
     * @param array $roles Roles
     *
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Salt Getter
     *
     * @return string|void|null
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     *
     * @return void
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * Password Getter
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Password Setter
     *
     * @param string $password Password
     *
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Siret Getter
     *
     * @return int|null
     */
    public function getSiret(): ?int
    {
        return $this->siret;
    }

    /**
     * Siret Setter
     *
     * @param int $siret Siret
     *
     * @return $this
     */
    public function setSiret(int $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Landline Getter
     *
     * @return mixed
     */
    public function getLandline()
    {
        return $this->landline;
    }

    /**
     * Landline Setter
     *
     * @param mixed $landline Landline
     *
     * @return User
     */
    public function setLandline($landline): self
    {
        $this->landline = $landline;

        return $this;
    }

    /**
     * Facebook Getter
     *
     * @return mixed
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Facebook Setter
     *
     * @param mixed $facebook Facebook
     *
     * @return User
     */
    public function setFacebook($facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Twitter Getter
     *
     * @return mixed
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Twitter Setter
     *
     * @param mixed $twitter Twitter
     *
     * @return User
     */
    public function setTwitter($twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Photo Getter
     *
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Photo Setter
     *
     * @param mixed $photo Photo
     *
     * @return User
     */
    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Creation date Getter
     *
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Creation date Setter
     *
     * @param mixed $created_at Creation date
     *
     * @return User
     */
    public function setCreatedAt($created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Update date Getter
     *
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Update date Setter
     *
     * @param mixed $updated_at Update date
     *
     * @return User
     */
    public function setUpdatedAt($updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * ToString function
     *
     * @return mixed
     */
    public function __toString()
    {
        return $this->name;
    }
}
