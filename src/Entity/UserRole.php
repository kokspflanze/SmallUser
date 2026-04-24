<?php

namespace SmallUser\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Table(name: 'user_role')]
#[ORM\Index(name: 'fk_users_role_users_role1_idx', columns: ['parent_id'])]
#[ORM\Entity(repositoryClass: \SmallUser\Entity\Repository\UserRole::class)]
class UserRole implements UserRoleInterface
{
    /**
     * @var integer
     */
    #[ORM\Column(name: 'id', type: 'integer', nullable: false)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private $id;

    /**
     * @var string
     */
    #[ORM\Column(name: 'role_id', type: 'string', length: 255, nullable: false)]
    private $roleId;

    /**
     * @var boolean
     */
    #[ORM\Column(name: 'is_default', type: 'boolean', nullable: true)]
    private $isDefault;

    /**
     * @var UserRoleInterface
     */
    #[ORM\ManyToOne(targetEntity: UserRole::class, inversedBy: 'parent_id')]
    private $parent;

    /**
     * @var Collection
     */
    #[ORM\JoinTable(name: 'user2role')]
    #[ORM\JoinColumn(name: 'user_role_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'user_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'userRole')]
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get roleId
     *
     * @return string
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * Set roleId
     *
     * @param string $roleId
     * @return UserRole
     */
    public function setRoleId($roleId)
    {
        $this->roleId = $roleId;

        return $this;
    }

    /**
     * Get isDefault
     *
     * @return boolean
     */
    public function getIsDefault()
    {
        return $this->isDefault;
    }

    /**
     * Set isDefault
     *
     * @param boolean $isDefault
     * @return UserRole
     */
    public function setIsDefault($isDefault)
    {
        $this->isDefault = $isDefault;

        return $this;
    }

    /**
     * Get parent
     *
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set parent
     *
     * @param string $parent
     * @return UserRole
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Add user
     *
     * @param UserInterface $user
     * @return UserRole
     */
    public function addUser(UserInterface $user)
    {
        $this->user[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param UserInterface $user
     */
    public function removeUser(UserInterface $user)
    {
        $this->user->removeElement($user);
    }

    /**
     * Get User user
     *
     * @return Collection
     */
    public function getUser()
    {
        return $this->user;
    }

}
