<?php

namespace SmallUser\Entity;

use BjyAuthorize\Provider\Role\ProviderInterface;

interface UserInterface extends ProviderInterface
{
    /**
     * @param self $entity
     * @param string $plaintext
     * @return bool
     */
    public static function hashPassword($entity, $plaintext);

    /**
     * @return int
     */
    public function getId();

    /**
     * Set username
     *
     * @param string $username
     * @return self
     */
    public function setUsername($username);

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername();

    /**
     * Set password
     *
     * @param string $password
     * @return self
     */
    public function setPassword($password);

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword();

    /**
     * @return \Zend\Permissions\Acl\Role\RoleInterface[]
     */
    public function getRoles();


} 