<?php

namespace SmallUser\Mapper;

use SmallUser\Entity\UserInterface as User;
use Laminas\Hydrator\ClassMethodsHydrator;

class HydratorUser extends ClassMethodsHydrator
{
    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     * @throws \Exception
     */
    public function extract(object $object): array
    {
        if (!$object instanceof User) {
            throw new \Exception('$object must be an instance of User');
        }

        /* @var $object User */
        return parent::extract($object);
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return object
     * @throws \Exception
     */
    public function hydrate(array $data, object $object)
    {
        if (!$object instanceof User) {
            throw new \Exception('$object must be an instance of User');
        }

        return parent::hydrate($data, $object);
    }
}