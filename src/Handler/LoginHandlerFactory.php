<?php

namespace SmallUser\Handler;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

class LoginHandlerFactory
{
    public function __invoke(ContainerInterface $container): LoginHandler
    {
        return new LoginHandler(
            $container->get(User::class),
            $container->get(TemplateRendererInterface::class)
        );
    }
}