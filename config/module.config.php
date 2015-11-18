<?php

return [
    'router' => [
        'routes' => [
            'small-user-auth' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/auth[/:action][/:code].html',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'code' => '[a-zA-Z0-9]*',
                    ],
                    'defaults' => [
                        'controller' => 'SmallUser\Controller\Auth',
                        'action' => 'login',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'invokables' => [
            'small_user_service' => 'SmallUser\Service\User',
            'zfcuser_user_service' => 'SmallUser\Service\User',
        ],
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'aliases' => [
            'zfcuser_zend_db_adapter' => 'Zend\Db\Adapter\Adapter',
        ],
    ],
    'controllers' => [
        'invokables' => [
            'SmallUser\Controller\Auth' => 'SmallUser\Controller\AuthController',
        ],
    ],
    'view_manager' => [
        'template_map' => [
            'small-user/login' => __DIR__ . '/../view/small-user/auth/login.phtml',
            'small-user/logout-page' => __DIR__ . '/../view/small-user/auth/logout-page.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'authenticationadapter' => [
        'odm_default' => [
            'objectManager' => 'doctrine.documentmanager.odm_default',
            'identityClass' => 'SmallUser\Entity\User',
            'identityProperty' => 'username',
            'credentialProperty' => 'password',
            'credentialCallable' => 'SmallUser\Entity\User::hashPassword'
        ],
    ],
    'doctrine' => [
        'driver' => [
            'application_entities' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/SmallUser/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    'SmallUser\Entity' => 'application_entities'
                ],
            ],
        ],
    ],
    'small-user' => [
        'user_entity' => [
            'class' => 'SmallUser\Entity\User',
            'username' => 'username'
        ],
        'login' => [
            'route' => ''
        ]
    ]
];
