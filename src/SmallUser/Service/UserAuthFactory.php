<?php


namespace SmallUser\Service;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use SmallUser\Model\AuthStorage;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserAuthFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return AuthenticationService
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var \DoctrineModule\Authentication\Adapter\ObjectRepository $adapter */
        $adapter = $container->get('doctrine.authenticationadapter.odm_default');

        // In Config there is not EntityManager =(, so we have to add it now =)
        $config = $container->get('config');
        $config = $config['authenticationadapter']['odm_default'];
        $config['objectManager'] = $container->get(EntityManager::class);
        $adapter->setOptions($config);

        $authService = new AuthenticationService();
        $authService->setStorage(new AuthStorage());
        return $authService->setAdapter($adapter);
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return AuthenticationService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, AuthenticationService::class);
    }

}