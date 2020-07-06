<?php

/**
 * UserTest class file
 *
 * PHP Version 7.1
 *
 * @category UserTest
 * @package  UserTest
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */

namespace App\Tests\Entity;

use App\Entity\Address;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * UserTest class
 *
 * The class holding the root UserTest class definition
 *
 * @category UserTest
 * @package  UserTest
 * @author   HumanAid <contact.humanaid@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     http://example.com/
 */
class UserTest extends TestCase
{
    /**
     * Test Event
     *
     * @return mixed
     */
    public function testUser()
    {
        $user    = new User();
        $address = new Address();

        $user->setName('User')
            ->setManagerFirstName('first_name')
            ->setManagerLastName('last_name')
            ->setUserName('Toto')
            ->setDescription('Test')
            ->setLandline('0612345678')
            ->setStatus('SARL')
            ->setWebsite('www.test.com')
            ->setEmail('test@test.com')
            ->setRoles(['ROLES_ASSOC'])
            ->setPassword('password')
            ->setSiret('12345678998765')
            ->setFacebook('https://www.facebook.com/')
            ->setTwitter('https://www.twitter.com/')
            ->addAddress($address);

        $this->assertEquals($user->getName(), 'User');
        $this->assertEquals($user->getManagerFirstName(), 'first_name');
        $this->assertEquals($user->getManagerLastName(), 'last_name');
        $this->assertEquals($user->getUserName(), 'Toto');
        $this->assertEquals($user->getDescription(), 'Test');
        $this->assertEquals($user->getLandline(), '0612345678');
        $this->assertEquals($user->getStatus(), 'SARL');
        $this->assertEquals($user->getWebsite(), 'www.test.com');
        $this->assertEquals($user->getEmail(), 'test@test.com');
        $this->assertEquals($user->getPassword(), 'password');
        $this->assertEquals($user->getSiret(), '12345678998765');
        $this->assertEquals($user->getFacebook(), 'https://www.facebook.com/');
        $this->assertEquals($user->getTwitter(), 'https://www.twitter.com/');

        foreach ($user->getAddresses() as $addr) {
            $this->assertEquals($address, $addr);
        }

        $user->removeAddress($address);
        $this->assertEmpty($user->getAddresses());
    }
}
