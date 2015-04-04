<?php

namespace SmallUser\Entity;

use BjyAuthorize\Acl\HierarchicalRoleInterface;

interface UserRoleInterface extends HierarchicalRoleInterface
{
    /**
     * Set roleId
     *
     * @param string $roleId
     * @return UserRole
     */
    public function setRoleId( $roleId );

    /**
     * Set parent
     *
     * @param string $parent
     * @return UserRole
     */
    public function setParent( $parent );

    /**
     * Get parent
     *
     * @return string
     */
    public function getParent();
} 