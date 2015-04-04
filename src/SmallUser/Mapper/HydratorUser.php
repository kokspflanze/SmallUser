<?php

namespace SmallUser\Mapper;

use ZfcUser\Mapper\Exception;
use Zend\Stdlib\Hydrator\ClassMethods;
use SmallUser\Entity\UserInterface as User;

class HydratorUser extends ClassMethods
{
	/**
	 * Extract values from an object
	 *
	 * @param  object $object
	 * @return array
	 * @throws Exception\InvalidArgumentException
	 */
	public function extract($object)
    {
		if (!$object instanceof User) {
			throw new Exception\InvalidArgumentException('$object must be an instance of User');
		}
		/* @var $object User */
		$data = parent::extract($object);

		return $data;
	}

	/**
	 * Hydrate $object with the provided $data.
	 *
	 * @param  array $data
	 * @param  object $object
	 * @return User
	 * @throws Exception\InvalidArgumentException
	 */
	public function hydrate(array $data, $object)
    {
		if (!$object instanceof User) {
			throw new Exception\InvalidArgumentException('$object must be an instance of User');
		}

		return parent::hydrate($data, $object);
	}
}