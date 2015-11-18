<?php


namespace SmallUser\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class UserRole extends EntityRepository
{
    /**
     * @param $name
     * @return null|\SmallUser\Entity\UserRole
     */
    public function getRole4Name($name)
    {
        return $this->findOneBy(['roleId' => $name]);
    }
}