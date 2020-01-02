<?php

namespace SmallUserTest\Entity;

use BjyAuthorize\Provider\Role\ProviderInterface;
use DateTime;
use Doctrine\Common\Collections\Collection;
use PHPUnit\Framework\TestCase;
use SmallUser\Entity\User;
use SmallUser\Entity\UserInterface;
use SmallUser\Entity\UserRole;
use Laminas\Crypt\Password\Bcrypt;
use Laminas\Permissions\Acl\Role\RoleInterface;

class UserTest extends TestCase
{
    public function testConstruct()
    {
        $entity = new User();

        $this->assertInstanceOf(DateTime::class, $entity->getCreated());
        $this->assertInstanceOf(UserInterface::class, $entity);
        $this->assertInstanceOf(ProviderInterface::class, $entity);
    }

    public function testUserId()
    {
        $entity = new User();
        $usrId = rand(0, 99999);
        $result = $entity->setId($usrId);

        $this->assertEquals($entity, $result);
        $this->assertEquals($usrId, $result->getId());
    }

    public function testUsername()
    {
        $entity = new User();
        $username = rand(0, 99999);
        $result = $entity->setUsername($username);

        $this->assertEquals($entity, $result);
        $this->assertEquals($username, $result->getUsername());
    }

    public function testPassword()
    {
        $entity = new User();
        $password = rand(0, 99999);
        $result = $entity->setPassword($password);

        $this->assertEquals($entity, $result);
        $this->assertEquals($password, $result->getPassword());
    }

    public function testEmail()
    {
        $entity = new User();
        $email = 'foo@bar.baz';
        $result = $entity->setEmail($email);

        $this->assertEquals($entity, $result);
        $this->assertEquals($email, $result->getEmail());
    }

    public function testCreated()
    {
        $entity = new User();
        $dateTime = new DateTime();
        $result = $entity->setCreated($dateTime);

        $this->assertEquals($entity, $result);
        $this->assertEquals($dateTime, $result->getCreated());
    }

    public function testAddUserRole()
    {
        $entity = new User();
        $entityRole = new UserRole();
        $result = $entity->addUserRole($entityRole);
        $this->assertEquals($entity, $result);

        $result = $entity->getUserRole();
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals($entityRole, $result[0]);
    }

    public function testRemoveUserRole()
    {
        $entity = new User();
        $entityRole = new UserRole();
        $entity->addUserRole($entityRole);

        $entity->removeUserRole($entityRole);

        $result = $entity->getUserRole();
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEmpty($result);
    }

    public function testGetRoles()
    {
        $entity = new User();
        $result = $entity->getRoles();
        $this->assertEmpty($result);

        $entityRole = new UserRole();
        $entity->addUserRole($entityRole);
        $result = $entity->getRoles();
        $this->assertTrue(is_array($result));
        $this->assertInstanceOf(RoleInterface::class, $result[0]);
    }

    public function testHashPassword()
    {
        $entity = new User();
        $password = 'foobar';
        $bCrypt = new Bcrypt();

        $entity->setPassword($bCrypt->create($password));
        $result = User::hashPassword($entity, $password);

        $this->assertTrue($result);
    }

}
