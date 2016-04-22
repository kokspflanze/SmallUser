<?php


namespace SmallUser\Service;


use Zend\Mvc\Controller\PluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserFactory implements FactoryInterface
{
    protected $className = User::class;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return User
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @noinspection PhpParamsInspection */
        return new $this->className(
            $serviceLocator->get(UserAuthFactory::class),
            $serviceLocator->get('small_user_login_form'),
            $serviceLocator->get('Config')['small-user'],
            $serviceLocator->get(PluginManager::class)
        );
    }

}