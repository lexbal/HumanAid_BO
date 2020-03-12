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
     * Location attribute
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

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
     * ID Getter
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
     * Location Getter
     *
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * Location Setter
     *
     * @param string $location Location
     *
     * @return $this
     */
    public function setLocation(string $location): self
    {
        $this->location = $location;

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
}
