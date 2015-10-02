<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Barabaka;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Zend\Session\Container;
use Barabaka\Service\Products;
use Zend\Stdlib\Hydrator;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
        
        /*---------- get all products ----------*/
        $hydrator = new Hydrator\ArraySerializable();
        $objectManager       = $e->getApplication()->getServiceManager()->get('Doctrine\ORM\EntityManager');
        $this->service_manager = $objectManager;
        $products_service = new Products($objectManager);
        
        $products         = $products_service->fetchAll();
        
        $products_arr     = array();
        foreach ( $products as $id => $product ) {
            $products_arr[$id] = $hydrator->extract($product);
        }
        
        $viewModel->products = $products;
        $viewModel->products_arr = $products_arr;
        /*---------- get all products ----------*/
        
        /*------------ get products in cart ---------------*/
        new Container();
        
        $products_in_cart = $_SESSION['products_in_cart'];
        
        $viewModel->global_session = $_SESSION;
        $viewModel->products_in_cart = $products_in_cart;
        /*------------ get products in cart ---------------*/
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
