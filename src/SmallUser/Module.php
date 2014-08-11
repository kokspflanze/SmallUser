<?php

namespace SmallUser;

use SmallUser\Model\AuthStorage;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {

	public function getConfig() {
		return include __DIR__ . '/../../config/module.config.php';
	}

	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				),
			),
		);
	}

	/**
	 * Expected to return \Zend\ServiceManager\Config object or array to
	 * seed such an object.
	 *
	 * @return array|\Zend\ServiceManager\Config
	 */
	public function getServiceConfig() {
		return array(
			'invokables' => array(
				'small_user_service'				=> 'SmallUser\Service\User',
			),
			'factories' => array(
				'small_user_auth_service' => function($sm){
					/** @var $sm \Zend\ServiceManager\ServiceLocatorInterface */
					/** @var \DoctrineModule\Authentication\Adapter\ObjectRepository $oAdapter */
					$oAdapter = $sm->get('doctrine.authenticationadapter.odm_default');

					// In Config there is not EntityManager =(, so we have to add it now =)
					$aConfig = $sm->get('Config');
					$aConfig = $aConfig['authenticationadapter']['odm_default'];
					$aConfig['objectManager'] = $sm->get('Doctrine\ORM\EntityManager');
					$oAdapter->setOptions( $aConfig );

					$oAuthService = new \Zend\Authentication\AuthenticationService();
					$oAuthService->setStorage( new AuthStorage() );
					return $oAuthService->setAdapter($oAdapter);
				},
				'small_user_login_form' => function(){
					$form = new Form\Login();
					$form->setInputFilter(new Form\LoginFilter());
					return $form;
				},
			),
		);
	}

}
