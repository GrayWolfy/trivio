<?php

declare(strict_types=1);

namespace Application;

use Application\Controller\DepartmentController;

use Application\Controller\EmployeeController;
use Application\Controller\EmployeeDepartmentController;
use Application\Controller\LanguageController;
use Application\Controller\UserController;
use Application\Factories\BirthPlaceTableFactory;
use Application\Factories\DepartmentServiceFactory;
use Application\Factories\DepartmentTableFactory;
use Application\Factories\EmployeeDepartmentServiceFactory;
use Application\Factories\EmployeeDepartmentTableFactory;
use Application\Factories\EmployeeServiceFactory;
use Application\Factories\EmployeeTableFactory;
use Application\Factories\UserServiceFactory;
use Application\Factories\UserTableFactory;
use Application\Models\BirthPlace\BirthPlaceTable;
use Application\Models\Department\DepartmentTable;
use Application\Models\Employee\EmployeeTable;
use Application\Models\EmployeeDepartment\EmployeeDepartmentTable;
use Application\Models\User\UserTable;
use Application\Services\DepartmentService;
use Application\Services\EmployeeDepartmentService;
use Application\Services\EmployeeService;
use Application\Services\UserService;
use Laminas\Db\Adapter\Adapter;
use Laminas\I18n\Translator\TranslatorServiceFactory;
use Laminas\Mvc\I18n\Translator;
use Laminas\Mvc\I18n\TranslatorFactory;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;


return [
    'router' => [
        'routes' => [
            'department' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/department[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\DepartmentController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'user' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/user[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\UserController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'employee' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/employee[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\EmployeeController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'employee_department' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/employeeDepartment[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\EmployeeDepartmentController::class,
                        'action' => 'index',
                    ],
                ],
            ],
            'language' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/language',
                    'defaults' => [
                        'controller' => LanguageController::class,
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            LanguageController::class => function ($container) {
                return new LanguageController($container->get(Translator::class));
            },
            Controller\IndexController::class => InvokableFactory::class,
            DepartmentController::class => function ($container) {
                return new DepartmentController($container->get(DepartmentService::class));
            },
            Controller\UserController::class => function ($container) {
                return new UserController($container->get(UserService::class));
            },

            EmployeeController::class => function ($container) {
                return new EmployeeController($container->get(EmployeeService::class));
            },

            EmployeeDepartmentController::class => function ($container) {
                return new EmployeeDepartmentController($container->get(EmployeeDepartmentService::class));
            }

        ],
    ],
    'view_manager' => [
        'base_path' => __DIR__ . '/public',
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',

        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
            'department' => __DIR__ . '/../view',
            'user' => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'DbAdapter' => function ($container) {
                $config = $container->get('config')['db'];
                $dbParams = [
                    'driver' => $config['driver'],
                    'dsn' => $config['dsn'],
                    'username' => $config['username'],
                    'password' => $config['password'],
                ];

                return new Adapter($dbParams);
            },
            DepartmentTable::class => DepartmentTableFactory::class,
            EmployeeTable::class => EmployeeTableFactory::class,
            UserTable::class => UserTableFactory::class,
            BirthPlaceTable::class => BirthPlaceTableFactory::class,
            EmployeeDepartmentTable::class => EmployeeDepartmentTableFactory::class,
            EmployeeDepartmentService::class => EmployeeDepartmentServiceFactory::class,
            DepartmentService::class => DepartmentServiceFactory::class,
            EmployeeService::class => EmployeeServiceFactory::class,
            UserService::class => UserServiceFactory::class,
            'translator' => TranslatorServiceFactory::class,
        ],
    ],
    'translator' => [
        'locale' => 'en_US',
        'translation_file_patterns' => [
            [
                'type' => 'phparray',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.php',
                'text_domain' => 'default',
            ],
        ],
    ],
];
