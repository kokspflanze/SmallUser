<?php


namespace SmallUser\Controller;


use Interop\Container\ContainerInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return AuthController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {/** @noinspection PhpParamsInspection */
        return new AuthController(
            $container->get('small_user_service')
        );
    }

    /**
     * @param ServiceLocatorInterface|AbstractPluginManager $serviceLocator
     * @return AuthController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator->getServiceLocator(), AuthController::class);
    }
}