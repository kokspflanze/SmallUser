<?php
declare(strict_types=1);

namespace SmallUser\Service;

use Doctrine\ORM\EntityManagerInterface;
use Mezzio\Authentication\UserInterface;
use Mezzio\Authentication\UserRepositoryInterface;

class DoctrineUserRepository implements UserRepositoryInterface
{
    public function __construct(private EntityManagerInterface $entityManager, private array $config) {}

    public function authenticate(string $credential, ?string $password = null): ?UserInterface
    {
        $repository = $this->entityManager->getRepository($this->config['user_entity']['class']);
        $user = $repository->findOneBy([$this->config['user_entity']['username'] => $credential]);

        if ($user && password_verify($password, $user->getPassword())) {
            return $user;
        }

        return null;
    }
}