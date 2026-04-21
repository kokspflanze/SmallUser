<?php

declare(strict_types=1);

namespace SmallUser\Service;

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
                    'class' => Entity\User::class,
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
            'aliases' => [
                'small_user_service' => Service\User::class,
                'zfcuser_user_service' => Service\User::class,
                'small_user_auth_service' => Service\UserAuthFactory::class,
                'small_user_login_form' => Form\LoginFactory::class,
            ],
            'factories' => [
                Service\User::class => Service\UserFactory::class,
                Service\UserAuthFactory::class => Service\UserAuthFactory::class,
                Form\LoginFactory::class => Form\LoginFactory::class,
            ],
        ];
    }

}
