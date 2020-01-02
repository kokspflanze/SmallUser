<?php

namespace SmallUser\Mapper;

use SmallUser\Entity\UserInterface as User;
use Laminas\Hydrator\ClassMethods;

class HydratorUser extends ClassMethods
{
    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     * @throws \Exception
     */
    public function extract($object)
    {
        if (!$object instanceof User) {
            throw new \Exception('$object must be an instance of User');
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
     * @throws \Exception
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof User) {
            throw new \Exception('$object must be an instance of User');
        }

        return parent::hydrate($data, $object);
    }
}