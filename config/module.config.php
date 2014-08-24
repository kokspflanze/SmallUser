<?php

return array(
	'router' => array(
		'routes' => array(
			'small-user-auth' => array(
				'type' => 'segment',
				'options' => array(
					'route'    => '/auth/[:action][/:code]',
					'constraints' => array(
						'action'   => '[a-zA-Z][a-zA-Z0-9_-]*',
						'code'     => '[a-zA-Z0-9]*',
					),
					'defaults' => array(
						'controller'	=> 'SmallUser\Controller\Auth',
						'action'		=> 'login',
					),
				),
			),
		),
	),
	'service_manager' => array(
		'abstract_factories' => array(
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
			'Zend\Log\LoggerAbstractServiceFactory',
		),
	),
	'controllers' => array(
		'invokables' => array(
			'SmallUser\Controller\Auth' => 'SmallUser\Controller\AuthController',
		),
	),
	'view_manager' => array(
		'template_map' => array(
			'small-user/login'			=> __DIR__ . '/../view/small-user/auth/login.phtml',
			'small-user/logout-page'	=> __DIR__ . '/../view/small-user/auth/logout-page.phtml',
		),
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),
	),
	'authenticationadapter' => array(
		'odm_default' => array(
			'objectManager' => 'doctrine.documentmanager.odm_default',
			'identityClass' => 'SmallUser\Entity\Users',
			'identityProperty' => 'username',
			'credentialProperty' => 'password',
			'credentialCallable' => 'SmallUser\Entity\Users::hashPassword'
		),
	),
	'doctrine' => array(
		'driver' => array(
			'application_entities' => array(
				'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => array(__DIR__ . '/../src/SmallUser/Entity')
			),
			'orm_default' => array(
				'drivers' => array(
					'SmallUser\Entity' => 'application_entities'
				),
			),
		),
	),
	'small-user' => array(
		'user_entity' => array(
			'class' => 'SmallUser\Entity\Users',
			'username' => 'username'
		)
	)
);
