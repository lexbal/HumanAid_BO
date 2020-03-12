<?php

namespace tests\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUser()
    {
        $user = new User();
        $user->setName('User');
        $user->setUserName('Toto');
        $user->setDescription('Test');
        $user->setStatus('SARL');
        $user->setLocation('Paris');
        $user->setWebsite('www.test.com');
        $user->setEmail('test@test.com');
        $user->setRoles(['USER_ASSOC']);
        $user->setPassword('password');
        $user->setSiret('12345678998765');
        
        $this->assertEquals($user->getId(), null);
        $this->assertEquals($user->getName(), 'User');
        $this->assertEquals($user->getUserName(), 'Toto');
        $this->assertEquals($user->getDescription(), 'Test');
        $this->assertEquals($user->getStatus(), 'SARL');
        $this->assertEquals($user->getLocation(), 'Paris');
        $this->assertEquals($user->getWebsite(), 'www.test.com');
        $this->assertEquals($user->getEmail(), 'test@test.com');
        $this->assertEquals($user->getPassword(), 'password');
        $this->assertEquals($user->getSiret(), '12345678998765');
    }

}
