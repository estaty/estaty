<?php

namespace Estaty\Test\Repository;

use Estaty\Model\User;
use Estaty\Test\TestCase;
use Estaty\Repository\UserRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * @coversDefaultClass Estaty\Repository\UserRepository
 */
class UserRepositoryTest extends TestCase
{
    /**
     * Get UserRepository mock via disabling the constructor.
     *
     * @param  array|null $methods optional methods to mock
     * @return UserRepository Mock of the user repository
     */
    public function getUserRepositoryMock($methods = [])
    {
        return $this->getMockBuilder('Estaty\Repository\UserRepository')
            ->disableOriginalConstructor()
            ->setMethods($methods)
            ->getMock();
    }

    protected function getEmMock()
    {
        return $this->getMockBuilder('Doctrine\Orm\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
     }

    /**
     * @covers ::loadUserByUsername
     */
    public function testLoadUserByUsername()
    {
        $user = new User(null, null, null, null);
        $repository = $this->getUserRepositoryMock(['loadUserByEmail']);

        $repository
            ->expects($this->once())
            ->method('loadUserByEmail')
            ->with('john')
            ->willReturn($user);

        $userLoaded = $repository->loadUserByUsername('john');
        $this->assertSame($user, $userLoaded);
    }

    /**
     * @covers ::loadUserByUsername
     */
    public function testLoadUserByUsernameThrowsUsernameNotFoundException()
    {
        $repository = $this->getUserRepositoryMock(['loadUserByEmail']);

        $repository
            ->expects($this->once())
            ->method('loadUserByEmail')
            ->with('non-existent')
            ->willReturn(null);

        $this->setExpectedException(
            'Symfony\Component\Security\Core\Exception\UsernameNotFoundException',
            'Username "non-existent" does not exist.'
        );
        $repository->loadUserByUsername('non-existent');
    }

    /**
     * @covers ::loadUserById
     */
    public function testLoadUserById()
    {
        $user = new User(null, null, null, null);
        $repository = $this->getUserRepositoryMock(['findOneBy']);

        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => 100])
            ->willReturn($user);

        $userLoaded = $repository->loadUserById(100);
        $this->assertSame($user, $userLoaded);
    }

    /**
     * @covers ::loadUserByEmail
     */
    public function testLoadUserByEmail()
    {
        $user = new User(null, null, null, null);
        $repository = $this->getUserRepositoryMock(['findOneBy']);

        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['email' => 'abc@example.com'])
            ->willReturn($user);

        $userLoaded = $repository->loadUserByEmail('abc@example.com');
        $this->assertSame($user, $userLoaded);
    }

    /**
     * @covers ::supportsClass
     */
    public function testSupportsClass()
    {
        $repository = $this->getUserRepositoryMock(null);
        $this->assertTrue($repository->supportsClass('Estaty\Model\User'));
        $this->assertTrue($repository->supportsClass('Symfony\Component\Security\Core\User\User'));
        $this->assertFalse($repository->supportsClass('NonExistent'));
    }

    /**
     * @covers ::refreshUser
     */
    public function testRefreshUser()
    {
        $repository = $this->getUserRepositoryMock([
            'supportsClass',
            'loadUserByUsername'
        ]);

        $repository
            ->expects($this->exactly(2))
            ->method('supportsClass')
            ->will($this->onConsecutiveCalls([true, false]));

        $user = new User(null, 'john', null, null);

        $repository
            ->expects($this->once())
            ->method('loadUserByUsername')
            ->with('john')
            ->will($this->returnValue($user));

        $userRefreshed = $repository->refreshUser($user);

        $this->assertSame($user, $userRefreshed);

        $userInterfaceMock = $this->getMock('Symfony\Component\Security\Core\User\UserInterface');

        $this->setExpectedException(
            'Symfony\Component\Security\Core\Exception\UnsupportedUserException',
            sprintf(
                'Instances of "%s" are not supported.',
                get_class($userInterfaceMock)
            )
        );
        $repository->refreshUser($userInterfaceMock);
    }

    /**
     * @covers ::loadUserByOAuthUid
     */
    public function testLoadUserByOAuthUid()
    {
        $user = new User(null, null, null, null);
        $repository = $this->getUserRepositoryMock(['findOneBy']);

        $repository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['facebookUid' => '123'])
            ->willReturn($user);

        $userLoaded = $repository->loadUserByOAuthUid(User::FACEBOOK, '123');
        $this->assertSame($user, $userLoaded);
    }

    /**
     * @covers ::loadUserByOAuthCredentials
     */
    public function testLoadUserByOAuthCredentialsByUid()
    {
        $token = $this->getMockBuilder('Gigablah\Silex\OAuth\Security\Authentication\Token\OAuthToken')
            ->disableOriginalConstructor()
            ->setMethods([
                'getService',
                'getUid',
            ])
            ->getMock();

        $token
            ->expects($this->once())
            ->method('getService')
            ->will($this->returnValue(User::FACEBOOK));

        $token
            ->expects($this->once())
            ->method('getUid')
            ->will($this->returnValue('123'));

        $repository = $this->getUserRepositoryMock(['loadUserByOAuthUid']);

        $user = new User(null, null, null, null);

        $repository
            ->expects($this->once())
            ->method('loadUserByOAuthUid')
            ->with(User::FACEBOOK, '123')
            ->will($this->returnValue($user));

        $userLoaded = $repository->loadUserByOAuthCredentials($token);
        $this->assertSame($user, $userLoaded);
    }

    /**
     * @covers ::loadUserByOAuthCredentials
     */
    public function testLoadUserByOAuthCredentialsByEmail()
    {
        $token = $this->getMockBuilder('Gigablah\Silex\OAuth\Security\Authentication\Token\OAuthToken')
            ->disableOriginalConstructor()
            ->setMethods([
                'getService',
                'getUid',
                'getEmail'
            ])
            ->getMock();

        $token
            ->expects($this->exactly(2))
            ->method('getService')
            ->will($this->returnValue(User::FACEBOOK));

        $token
            ->expects($this->exactly(2))
            ->method('getUid')
            ->will($this->returnValue('123'));

        $token
            ->expects($this->once())
            ->method('getEmail')
            ->will($this->returnValue('john.doe@example.com'));

        $repository = $this->getUserRepositoryMock([
            'loadUserByOAuthUid',
            'loadUserByEmail',
            'getEntityManager',
        ]);

        $repository
            ->expects($this->once())
            ->method('getEntityManager')
            ->will($this->returnValue($this->getEmMock()));

        $user = $this->getMockBuilder('Estaty\Model\User')
            ->setMethods([
                'setOAuthServiceUid',
            ])
            ->disableOriginalConstructor()
            ->getMock();

        $user
            ->expects($this->once())
            ->method('setOAuthServiceUid')
            ->with(User::FACEBOOK, '123');

        $repository
            ->expects($this->once())
            ->method('loadUserByOAuthUid')
            ->with(User::FACEBOOK, '123')
            ->will($this->returnValue(null));

        $repository
            ->expects($this->once())
            ->method('loadUserByEmail')
            ->with('john.doe@example.com')
            ->will($this->returnValue($user));

        $userLoaded = $repository->loadUserByOAuthCredentials($token);
        $this->assertSame($user, $userLoaded);
    }

    /**
     * @covers ::loadUserByOAuthCredentials
     * @covers ::createUserFromOAuthToken
     */
    public function testLoadUserByOAuthCredentialsByCreatingNewUser()
    {
        $token = $this->getMockBuilder('Gigablah\Silex\OAuth\Security\Authentication\Token\OAuthToken')
            ->disableOriginalConstructor()
            ->setMethods([
                'getService',
                'getUid',
                'getEmail',
                'getUser',
            ])
            ->getMock();

        $token
            ->expects($this->exactly(2))
            ->method('getService')
            ->will($this->returnValue(User::FACEBOOK));

        $token
            ->expects($this->exactly(2))
            ->method('getUid')
            ->will($this->returnValue('123'));

        $token
            ->expects($this->exactly(2))
            ->method('getEmail')
            ->will($this->returnValue('john.doe@example.com'));

        $token
            ->expects($this->once())
            ->method('getUser')
            ->will($this->returnValue('John Doe'));

        $repository = $this->getUserRepositoryMock([
            'loadUserByOAuthUid',
            'loadUserByEmail',
            'getEntityManager',
        ]);

        $repository
            ->expects($this->once())
            ->method('getEntityManager')
            ->will($this->returnValue($this->getEmMock()));

        $repository
            ->expects($this->once())
            ->method('loadUserByOAuthUid')
            ->with(User::FACEBOOK, '123')
            ->will($this->returnValue(null));

        $repository
            ->expects($this->once())
            ->method('loadUserByEmail')
            ->with('john.doe@example.com')
            ->will($this->returnValue(null));

        $user = $repository->loadUserByOAuthCredentials($token);
        $this->assertInstanceOf('Estaty\Model\User', $user);
        $this->assertSame('john.doe@example.com', $user->getEmail());
        $this->assertSame('John Doe', $user->getName());
        $this->assertSame(['ROLE_USER'], $user->getRoles());
        $this->assertNull($user->getPassword());
        $this->assertSame('123', $user->getOAuthServiceUid(User::FACEBOOK));
    }
}
