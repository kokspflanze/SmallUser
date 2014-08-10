<?php

namespace SmallUser\Entity;


interface UsersInterface {


	/**
	 * Get usrid
	 *
	 * @return integer
	 */
	public function getUsrid();

	/**
	 * Set username
	 *
	 * @param string $username
	 *
	 * @return Users
	 */
	public function setUsername( $username );

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
	 *
	 * @return Users
	 */
	public function setPassword( $password );

	/**
	 * Get password
	 *
	 * @return string
	 */
	public function getPassword();

	/**
	 * Set email
	 *
	 * @param string $email
	 *
	 * @return Users
	 */
	public function setEmail( $email );

	/**
	 * Get email
	 *
	 * @return string
	 */
	public function getEmail();

	/**
	 * Set created
	 *
	 * @param \DateTime $created
	 *
	 * @return Users
	 */
	public function setCreated( $created );

	/**
	 * Get created
	 *
	 * @return \DateTime
	 */
	public function getCreated();

	/**
	 * Add userRole
	 *
	 * @param UserRole $role
	 *
	 * @return Users
	 */
	public function addUserRole( $role );

	/**
	 * Remove userRole
	 *
	 * @param UserRole $role
	 */
	public function removeUserRole( $role );

	/**
	 * Get userRole
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getUserRole();

	/**
	 * @return \Zend\Permissions\Acl\Role\RoleInterface[]
	 */
	public function getRoles();

	/**
	 * @param Users $oEntity
	 * @param       $plaintext
	 *
	 * @return bool
	 */
	public static function hashPassword( $oEntity, $plaintext );


} 