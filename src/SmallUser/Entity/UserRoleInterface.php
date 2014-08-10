<?php

namespace SmallUser\Entity;


interface UserRoleInterface {


	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId();

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
	 * Set isDefault
	 *
	 * @param boolean $isDefault
	 *
	 * @return UserRole
	 */
	public function setIsDefault( $isDefault );

	/**
	 * Get isDefault
	 *
	 * @return boolean
	 */
	public function getIsDefault();

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

	/**
	 * Add usersUsrid
	 *
	 * @param UsersInterface $user
	 *
	 * @return UserRole
	 */
	public function addUsersUsrid( UsersInterface $user );

	/**
	 * Remove usersUsrid
	 *
	 * @param UsersInterface $user
	 */
	public function removeUsersUsrid( UsersInterface $user );

	/**
	 * Get Users usersUsrid
	 *
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function getUsersUsrid();
} 