<?php

namespace SmallUser\Service;

use Interop\Container\ContainerInterface;
use Laminas\Form\FormAbstractServiceFactory;
use Laminas\Mvc\Controller\PluginManager;
use Laminas\ServiceManager\Factory\FactoryInterface;

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
            $container->get('FormElementManager')->get(\SmallUser\Form\Login::class),
            $container->get('config')['small-user'],
            $container->get(PluginManager::class)
        );
    }

}
