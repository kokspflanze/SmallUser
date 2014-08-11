<?php

namespace SmallUser\Entity;


interface UsersInterface {

	/**
	 * Set username
	 *
	 * @param string $username
	 *
	 * @return UsersInterface
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
	 * @return UsersInterface
	 */
	public function setPassword( $password );

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

	/**
	 * @param UsersInterface $oEntity
	 * @param       $plaintext
	 *
	 * @return bool
	 */
	public static function hashPassword( $oEntity, $plaintext );


} 