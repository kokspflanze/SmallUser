<?php
declare(strict_types=1);

namespace SmallUser\Service;

use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

class DoctrineUserRepositoryFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new DoctrineUserRepository(
            $container->get(EntityManagerInterface::class),
            $container->get('config')['small-user']
        );
    }

}