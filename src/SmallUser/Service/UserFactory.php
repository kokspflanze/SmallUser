<?php


namespace SmallUser\Service;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserFactory implements FactoryInterface
{
    protected $className = 'User';
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return User
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @noinspection PhpParamsInspection */
        return new $this->className(
            $serviceLocator->get('small_user_auth_service'),
            $serviceLocator->get('small_user_login_form'),
            $serviceLocator->get('Config')['small-user'],
            $serviceLocator->get('ControllerPluginManager')
        );
    }

}