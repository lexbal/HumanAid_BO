<?php

namespace tests\Controller;

use App\Entity\User;
use App\Controller\UserController;
use ORM\EntityManagerInterface;
use App\Repository\UserRepository;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserControllerTest extends TestCase 
{
    /** @var UserRepository|PHPUnit_Framework_MockObject_MockObject */
    private $userRepositoryMock;
    /** @var EntityManagerInterface|PHPUnit_Framework_MockObject_MockObject */
    private $entityManagerInterfaceMock;
    /** @var UserPasswordEncoderInterface|PHPUnit_Framework_MockObject_MockObject */
    private $encoderMock;
    /** @var User|PHPUnit_Framework_MockObject_MockObject */
    private $userMock;
    /** @var UserController */
    private $userController;

    protected function setUp()
    {
        $this->userRepositoryMock = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
 
        $this->entityManagerInterfaceMock = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['persist', 'flush'])
            ->getMock();

        $this->encoderMock = $this->getMockBuilder(UserPasswordEncoderInterface::class)
            ->setMethods(['encodePassword', 'isPasswordValid'])
            ->getMock();
        
        $this->userControllerMock = $this->getMockBuilder(UserController::class)
            ->setMethods(['new'])
            ->getMock();

        $this->userController = new UserController(
            $this->userRepositoryMock,
            $this->entityManagerInterfaceMock,
            $this->encoderMock,
            $this->userMock
        );
    }
 
    protected function tearDown()
    {
        $this->userRepositoryMock = null;
        $this->entityManagerInterfaceMock = null;
        $this->encoderMock = null;
        $this->userMock = null;
    }

    public function testNew()
    {
        $user = new User();
        $user->setName('User');
        $user->setUserName('Toto');
        $user->setDescription('Test');
        $user->setStatus('SARL');
        $user->setLocation('Paris');
        $user->setWebsite('www.test.com');
        $user->setEmail('test@test.com');
        $user->setPassword('password');
        $user->setSiret('12345678998765');
        
        $this->entityManagerInterfaceMock
            ->expects($this->once())  
            ->method('persist')
            ->with($user);

        $this->entityManagerInterfaceMock  
            ->expects($this->once())          
            ->method('flush');

        $this->encoderMock
            ->expects($this->once())
            ->method('encodePassword');
        
        $this->encoderMock
            ->expects($this->once())
            ->method('isPasswordValid');
        
        $this->userMock
            ->expects($this->once())  
            ->method('persist')
            ->with($user);
            
            $result = $this->userController->new( new Request(
            [
                    'name' => 'User',
                    'username' => 'Toto',
                    'description' => 'Test',
                    'status' => 'SARL',
                    'location' => 'Paris',
                    'website' => 'www.test.com',
                    'email' => 'test@test.com',
                    'password' => 'password',
                    'siret' => '12345678998765',
            ]
        ),  encoderMock('user')
        );

        $this->assertEquals($user->getId(), $result);
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
