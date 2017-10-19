<?php

namespace SmallUser\Service;

use Interop\Container\ContainerInterface;
use Zend\Mvc\Controller\PluginManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserFactory implements FactoryInterface
{
    /** @var  string*/
    protected $className = User::class;

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @noinspection PhpParamsInspection */
        return new $this->className(
            $container->get(UserAuthFactory::class),
            $container->get('small_user_login_form'),
            $container->get('config')['small-user'],
            $container->get(PluginManager::class)
        );
    }

}