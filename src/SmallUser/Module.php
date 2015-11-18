<?php

namespace SmallUser;

use SmallUser\Model\AuthStorage;

class Module
{
    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'small_user_auth_service' => function ($sm) {
                    /** @var $sm \Zend\ServiceManager\ServiceLocatorInterface */
                    /** @var \DoctrineModule\Authentication\Adapter\ObjectRepository $adapter */
                    $adapter = $sm->get('doctrine.authenticationadapter.odm_default');

                    // In Config there is not EntityManager =(, so we have to add it now =)
                    $config = $sm->get('Config');
                    $config = $config['authenticationadapter']['odm_default'];
                    $config['objectManager'] = $sm->get('Doctrine\ORM\EntityManager');
                    $adapter->setOptions($config);

                    $authService = new \Zend\Authentication\AuthenticationService();
                    $authService->setStorage(new AuthStorage());
                    return $authService->setAdapter($adapter);
                },
                'small_user_login_form' => function () {
                    $form = new Form\Login();
                    $form->setInputFilter(new Form\LoginFilter());
                    return $form;
                },
            ],
        ];
    }

}
