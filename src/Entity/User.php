<?php

namespace SmallUser\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * User
 */
#[ORM\Table(name: 'user')]
#[ORM\UniqueConstraint(name: 'username_UNIQUE', columns: ['username'])]
#[ORM\MappedSuperclass]
#[ORM\Entity(repositoryClass: \SmallUser\Entity\Repository\User::class)]
class User implements UserInterface
{

    /**
     * @var integer|null
     */
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $usrId = null;


    #[ORM\Column(name: 'username', type: 'string', length: 60, nullable: false)]
    private $username = '';


    #[ORM\Column(name: 'password', type: 'string', length: 60, nullable: false)]
    private $password = '';


    #[ORM\Column(name: 'email', type: 'string', length: 60, nullable: false)]
    private $email = '';


    #[ORM\Column(name: 'created', type: 'datetime', nullable: false)]
    private ?DateTime $created = null;


    /** @var UserRole[] */
    #[ORM\ManyToMany(targetEntity: \SmallUser\Entity\UserRole::class, mappedBy: 'user')]
    private $userRole;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->userRole = new ArrayCollection();
        $this->created = new DateTime();
    }

    /**
     * @param User $entity
     * @param       $plaintext
     * @return bool
     */
    public static function hashPassword($entity, $plaintext)
    {
        return password_verify($plaintext, $entity->getPassword());
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set usrId
     *
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->usrId = $id;

        return $this;
    }

    /**
     * Get usrId
     *
     * @return integer
     */
    public function getId()
    {
        return $this->usrId;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set username
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get created
     *
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set created
     * @param DateTime $created
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Add userRole
     * @param UserRole $role
     * @return User
     */
    public function addUserRole($role)
    {
        $this->userRole[] = $role;

        return $this;
    }

    /**
     * Remove userRole
     *
     * @param UserRole $role
     */
    public function removeUserRole($role)
    {
        $this->userRole->removeElement($role);
    }

    /**
     * Get userRole
     *
     * @return Collection
     */
    public function getUserRole()
    {
        return $this->userRole;
    }

    /**
     * @return \Laminas\Permissions\Acl\Role\RoleInterface[]
     */
    public function getRoles(): iterable
    {
        $roleReturn = [];
        foreach ($this->userRole as $role) {
            $roleReturn[] = $role->getRoleId();
        }

        return $roleReturn;
    }

    public function getIdentity() : string
    {
        return (string)$this->usrId;
    }

    public function getDetail(string $name, $default = null)
    {
        return $this->{$name} ?? $default;
    }

    public function getDetails() : array
    {
        return [];
    }

}
