<?php

namespace Estaty\Test\Model\User;

use Estaty\Test\TestCase;
use Estaty\Model\User;

/**
 * @coversDefaultClass Estaty\Model\User
 */
class UserTest extends TestCase
{
    const ID = 1;
    const EMAIL = 'john.doe@example.com';
    const PASSWORD = '12345678';
    const NAME = 'John Doe';

    public function getUser()
    {
        return new User(self::ID, self::EMAIL, self::PASSWORD, self::NAME, [
            'ROLE_USER'
        ]);
    }
    /**
     * @covers ::__construct
     */
    public function testConstructor()
    {
        $user = new User(self::ID, self::EMAIL, self::PASSWORD, self::NAME);
        $this->assertEquals(self::ID, $user->getId());
        $this->assertEquals(self::EMAIL, $user->getEmail());
        $this->assertEquals(self::PASSWORD, $user->getPassword());
        $this->assertEquals(self::NAME, $user->getName());
        $this->assertEquals(self::EMAIL, $user->getUsername());
        $this->assertEquals([], $user->getRoles());

        $user = new User(null, self::EMAIL, self::PASSWORD, self::NAME, [
            'ROLE_USER',
        ]);
        $this->assertEquals(null, $user->getId());
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    /**
     * @covers ::getId
     */
    public function testGetId()
    {
        $user = $this->getUser();
        $this->assertEquals(self::ID, $user->getId());
    }

    /**
     * @covers ::getName
     */
    public function testGetName()
    {
        $user = $this->getUser();
        $this->assertEquals(self::NAME, $user->getName());
    }

    /**
     * @covers ::setName
     */
    public function testSetName()
    {
        $user = $this->getUser();
        $user->setName('ABC');
        $this->assertEquals('ABC', $user->getName());
    }

    /**
     * @covers ::getEmail
     */
    public function testGetEmail()
    {
        $user = $this->getUser();
        $this->assertEquals(self::EMAIL, $user->getEmail());
    }

    /**
     * @covers ::setEmail
     */
    public function testSetEmail()
    {
        $user = $this->getUser();
        $user->setEmail('abc@example.com');
        $this->assertEquals('abc@example.com', $user->getEmail());
    }

    /**
     * @covers ::getPassword
     */
    public function testGetPassword()
    {
        $user = $this->getUser();
        $this->assertEquals(self::PASSWORD, $user->getPassword());
    }

    /**
     * @covers ::setPassword
     */
    public function testSetPassword()
    {
        $user = $this->getUser();
        $user->setPassword('qwertyuiop');
        $this->assertEquals('qwertyuiop', $user->getPassword());
    }

    /**
     * @covers ::getRoles
     */
    public function testGetRoles()
    {
        $user = $this->getUser();
        $this->assertEquals(['ROLE_USER'], $user->getRoles());
    }

    /**
     * @covers ::setRoles
     */
    public function testSetRoles()
    {
        $user = $this->getUser();
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $this->assertEquals(['ROLE_USER', 'ROLE_ADMIN'], $user->getRoles());
    }

    /**
     * @covers ::getFacebookUid
     * @covers ::setFacebookUid
     */
    public function testGetAndSetFacebookUid()
    {
        $user = $this->getUser();
        $this->assertNull($user->getFacebookUid());
        $user->setFacebookUid('123');
        $this->assertEquals('123', $user->getFacebookUid());
    }

    /**
     * @covers ::getGoogleUid
     * @covers ::setGoogleUid
     */
    public function testGetAndSetGoogleUid()
    {
        $user = $this->getUser();
        $this->assertNull($user->getGoogleUid());
        $user->setGoogleUid('123');
        $this->assertEquals('123', $user->getGoogleUid());
    }

    /**
     * @covers ::getGithubUid
     * @covers ::setGithubUid
     */
    public function testGetAndSetGithubUid()
    {
        $user = $this->getUser();
        $this->assertNull($user->getGithubUid());
        $user->setGithubUid('123');
        $this->assertEquals('123', $user->getGithubUid());
    }

    /**
     * @covers ::getSalt
     */
    public function testGetSalt()
    {
        $user = $this->getUser();
        $this->assertNull($user->getSalt());
    }

    /**
     * @covers ::getUsername
     */
    public function testGetUsername()
    {
        $user = $this->getUser();
        $this->assertEquals(self::EMAIL, $user->getUsername());
    }

    /**
     * @covers ::supportsOAuthService
     */
    public function testSupportsOAuthService()
    {
        $user = $this->getUser();
        $this->assertTrue($user->supportsOAuthService(User::FACEBOOK));
        $this->assertTrue($user->supportsOAuthService(User::GOOGLE));
        $this->assertTrue($user->supportsOAuthService(User::GITHUB));
    }

    /**
     * @covers ::getOAuthServiceUid
     * @covers ::setOAuthServiceUid
     */
    public function testGetAndSetOAuthServiceUid()
    {
        $user = $this->getUser();
        $user->setOAuthServiceUid(User::FACEBOOK, '123');
        $this->assertEquals('123', $user->getOAuthServiceUid(User::FACEBOOK));
    }

    /**
     * @covers ::getOAuthServiceUid
     */
    public function testGetOAuthServiceUidThrowsOutOfBoundsException()
    {
        $user = $this->getUser();
        $this->setExpectedException('OutOfBoundsException', 'NOT EXISTENT is not a supported OAuth service');
        $user->getOAuthServiceUid('NOT EXISTENT');
    }

    /**
     * @covers ::setOAuthServiceUid
     */
    public function testSetOAuthServiceUidThrowsOutOfBoundsException()
    {
        $user = $this->getUser();
        $this->setExpectedException('OutOfBoundsException', 'NOT EXISTENT is not a supported OAuth service');
        $user->setOAuthServiceUid('NOT EXISTENT', '123');
    }
}
