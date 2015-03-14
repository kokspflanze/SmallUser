<?php

namespace SmallUser\Entity;


interface UserRoleInterface
{

    /**
     * Set roleId
     *
     * @param string $roleId
     *
     * @return UserRole
     */
    public function setRoleId( $roleId );

    /**
     * Get roleId
     *
     * @return string
     */
    public function getRoleId();

    /**
     * Set parent
     *
     * @param string $parent
     *
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