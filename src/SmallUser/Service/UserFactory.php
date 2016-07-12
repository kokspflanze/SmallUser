<?php


namespace SmallUser\Service;


use Interop\Container\ContainerInterface;
use Zend\Mvc\Controller\PluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

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
            $container->get('Config')['small-user'],
            $container->get(PluginManager::class)
        );
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return User
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, $this->className);
    }

}