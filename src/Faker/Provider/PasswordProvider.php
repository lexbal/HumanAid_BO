<?php

/**
 * PasswordProvider class file
 *
 * PHP Version 7.1
 *
 * @category PasswordProvider
 * @package  PasswordProvider
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Faker\Provider;

use App\Entity\User;
use Faker\Generator;
use Faker\Provider\Base as BaseProvider;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * PasswordProvider class
 *
 * The class holding the root PasswordProvider class definition
 *
 * @category PasswordProvider
 * @package  PasswordProvider
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */
final class PasswordProvider extends BaseProvider
{
    private $_password;
    private $_passwordEncoder;

    /**
     * PasswordProvider constructor.
     * @param Generator $generator
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(Generator $generator, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct($generator);
        $this->_passwordEncoder = $passwordEncoder;
    }

    /**
     * @param string $password
     * @return string
     */
    public function passwordGenerator(string $password)
    {
        $user = new User();
        $this->_password = $this->_passwordEncoder->encodePassword(
            $user,
            $password
        );
        return $this->_password;
    }
}