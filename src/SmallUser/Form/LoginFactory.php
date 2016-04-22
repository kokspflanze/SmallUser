<?php


namespace SmallUser\Form;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LoginFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Login
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new Login();
        $form->setInputFilter(new LoginFilter());

        return $form;
    }

}