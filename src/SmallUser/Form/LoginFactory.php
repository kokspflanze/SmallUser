<?php

namespace SmallUser\Form;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

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

}