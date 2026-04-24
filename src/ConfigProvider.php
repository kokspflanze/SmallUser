<?php

declare(strict_types=1);

namespace SmallUser;

use Laminas\ServiceManager\Factory\InvokableFactory;
use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Authentication\Session\PhpSession;
use Mezzio\Authentication\UserRepositoryInterface;
use SmallUser\Entity;
use SmallUser\Form;
use SmallUser\Service;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'small-user' => [
                'user_entity' => [
                    'class' => Entity\UserInterface::class,
                    'username' => 'username'
                ],
                'login' => [
                    'route' => '',
                ],
            ],
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'aliases'    => [
                AuthenticationInterface::class => PhpSession::class,
                UserRepositoryInterface::class => DoctrineUserRepository::class,
                Entity\UserInterface::class => Entity\User::class,
            ],
            'factories' => [
                Entity\User::class => InvokableFactory::class,
                Form\LoginFactory::class => Form\LoginFactory::class,
                Handler\LoginHandler::class    => Handler\LoginHandlerFactory::class,
                Service\User::class => Service\UserFactory::class,
                Service\DoctrineUserRepository::class => Service\DoctrineUserRepositoryFactory::class,
            ],
        ];
    }

}
