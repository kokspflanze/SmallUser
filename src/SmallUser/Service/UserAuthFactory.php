<?php


namespace SmallUser\Service;

use Doctrine\ORM\EntityManager;
use SmallUser\Model\AuthStorage;
use Zend\Authentication\AuthenticationService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserAuthFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return AuthenticationService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \DoctrineModule\Authentication\Adapter\ObjectRepository $adapter */
        $adapter = $serviceLocator->get('doctrine.authenticationadapter.odm_default');

        // In Config there is not EntityManager =(, so we have to add it now =)
        $config = $serviceLocator->get('config');
        $config = $config['authenticationadapter']['odm_default'];
        $config['objectManager'] = $serviceLocator->get(EntityManager::class);
        $adapter->setOptions($config);

        $authService = new AuthenticationService();
        $authService->setStorage(new AuthStorage());
        return $authService->setAdapter($adapter);
    }

}