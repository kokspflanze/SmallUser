<?php

namespace SmallUser\Entity;

interface UserRoleInterface
{
    /**
     * Set roleId
     *
     * @param string $roleId
     * @return UserRole
     */
    public function setRoleId($roleId);

    /**
     * Set parent
     *
     * @param string $parent
     * @return UserRole
     */
    public function setParent($parent);

    /**
     * Get parent
     *
     * @return string
     */
    public function getParent();
} 