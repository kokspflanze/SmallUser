<?php


namespace SmallUser\Form;


use Interop\Container\ContainerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoginFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return Login
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new Login();
        $form->setInputFilter(new LoginFilter());

        return $form;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Login
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this($serviceLocator, Login::class);
    }

}