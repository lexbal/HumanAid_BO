<?php

namespace App\Faker\Provider;

use App\Entity\User;
use Faker\Generator;
use Faker\Provider\Base as BaseProvider;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class PasswordProvider
 * @package App\Faker\Provider
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