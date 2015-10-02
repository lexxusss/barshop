<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'doctrine' => array(
        'driver' => array(
            'barabaka_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Barabaka/Entity')
            ),
            
            'orm_default' => array(
                'drivers' => array(
                    'Barabaka\Entity' => 'barabaka_entities'
                )
            )
        )
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Barabaka\Controller',
                        'controller' => 'Index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'test' => array(
                        'type'    => 'literal',
                        'options' => array(
                            'route'    => 'test',
                            'defaults' => array(
                                'action'     => 'testing',
                            ),
                        ),
                    ),
                    'category' => array(
                        'type'    => 'literal',
                        'options' => array(
                            'route'    => 'category',
                            'defaults' => array(
                                'action'     => 'category',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'kitchen' => array(
                                'type'    => 'literal',
                                'options' => array(
                                    'route'    => '?categ=for_Kitchen',
                                ),
                            ),
                            'decor' => array(
                                'type'    => 'literal',
                                'options' => array(
                                    'route'    => '?categ=for_Decoration',
                                ),
                            ),
                            'for_you' => array(
                                'type'    => 'literal',
                                'options' => array(
                                    'route'    => '?categ=for_You',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'cart-manager' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/cart-manager',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Barabaka\Controller',
                        'controller' => 'Cart',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'add-into-cart' => array(
                        'type'    => 'literal',
                        'options' => array(
                            'route'    => '/add-into-cart',
                            'defaults' => array(
                                'action'     => 'add-into-cart',
                            ),
                        ),
                    ),
                    'remove-from-cart' => array(
                        'type'    => 'literal',
                        'options' => array(
                            'route'    => '/remove-from-cart',
                            'defaults' => array(
                                'action'     => 'remove-from-cart',
                            ),
                        ),
                    ),
                    'products-in-cart' => array(
                        'type'    => 'literal',
                        'options' => array(
                            'route'    => '/products-in-cart',
                            'defaults' => array(
                                'action'     => 'products-in-cart',
                            ),
                        ),
                    ),
                ),
            ),
            'category-manager' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/category-manager',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Barabaka\Controller',
                        'controller' => 'Category',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'add-into-cart' => array(
                        'type'    => 'literal',
                        'options' => array(
                            'route'    => '/pagination',
                            'defaults' => array(
                                'action'     => 'pagination',
                            ),
                        ),
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
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Barabaka\Controller\Index' => 'Barabaka\Controller\IndexController',
            'Barabaka\Controller\Cart' => 'Barabaka\Controller\CartController',
            'Barabaka\Controller\Category' => 'Barabaka\Controller\CategoryController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
