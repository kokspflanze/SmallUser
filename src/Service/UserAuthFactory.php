<?php

namespace SmallUser\Service;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Laminas\Authentication\Storage\Session;
use SmallUser\Model\AuthStorage;
use Laminas\Authentication\AuthenticationService;
use Laminas\ServiceManager\Factory\FactoryInterface;

class UserAuthFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return AuthenticationService
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        /** @var \DoctrineModule\Authentication\Adapter\ObjectRepository $adapter */
        $adapter = $container->get('doctrine.authenticationadapter.odm_default');

        // in config there is no EntityManager =(, so we have to add it now =)
        $configMain = $container->get('config');

        $authService = new UserAuth();
        $authService->setStorage(new AuthStorage(
            new Session(),
            $container->get(EntityManager::class),
            $configMain['small-user']['user_entity']['class']
        ));

        return $authService->setAdapter($adapter);
    }

}
