<?php

namespace SmallUser\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use SmallUser\Entity\UserRoleInterface;

class UserRole extends EntityRepository
{
    /**
     * @param $name
     * @return null|UserRoleInterface
     */
    public function getRole4Name($name)
    {
        return $this->findOneBy(['roleId' => $name]);
    }
}