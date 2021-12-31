<?php
namespace SmallUser\Model;

use Doctrine\ORM\EntityManagerInterface;
use Laminas\Authentication\Storage;
use SmallUser\Entity;

class AuthStorage implements Storage\StorageInterface
{
    /**
     * @var Storage\StorageInterface
     */
    protected $storage;

    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    protected $resolvedIdentity = null;

    /**
     * @var string
     */
    protected $entityClass = '';

    /**
     * @param Storage\StorageInterface $storage
     * @param EntityManagerInterface $entityManager
     * @param string $entityClass
     */
    public function __construct(Storage\StorageInterface $storage, EntityManagerInterface $entityManager, string $entityClass)
    {
        $this->storage = $storage;
        $this->entityManager = $entityManager;
        $this->entityClass = $entityClass;
    }

    /**
     * Returns true if and only if storage is empty
     *
     * @throws \Laminas\Authentication\Exception\InvalidArgumentException If it is impossible to determine whether
     * storage is empty or not
     * @return boolean
     */
    public function isEmpty()
    {
        if ($this->storage->isEmpty()) {
            return true;
        }
        $identity = $this->storage->read();
        if ($identity === null) {
            $this->clear();
            return true;
        }

        return false;
    }

    /**
     * Returns the contents of storage
     *
     * Behavior is undefined when storage is empty.
     *
     * @throws \Laminas\Authentication\Exception\InvalidArgumentException If reading contents from storage is impossible
     * @return mixed
     */
    public function read()
    {
        if (null !== $this->resolvedIdentity) {
            return $this->resolvedIdentity;
        }

        $identity = $this->storage->read();

        if (is_int($identity) || is_scalar($identity)) {
            $identity = $this->getUser($identity);
        }

        if ($identity) {
            $this->resolvedIdentity = $identity;
        } else {
            $this->resolvedIdentity = null;
        }

        return $this->resolvedIdentity;
    }

    /**
     * Writes $contents to storage
     *
     * @param  mixed $contents
     * @throws \Laminas\Authentication\Exception\InvalidArgumentException If writing $contents to storage is impossible
     * @return void
     */
    public function write($contents)
    {
        $this->resolvedIdentity = null;
        $this->storage->write($contents);
    }

    /**
     * Clears contents from storage
     *
     * @throws \Laminas\Authentication\Exception\InvalidArgumentException If clearing contents from storage is impossible
     * @return void
     */
    public function clear()
    {
        $this->resolvedIdentity = null;
        $this->storage->clear();
    }

    protected function getUser(int $id)
    {
        /** @var Entity\Repository\User $userRepo */
        $userRepo = $this->entityManager->getRepository($this->entityClass);

        return $userRepo->getUser4Id($id);
    }
}