<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Barabaka\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Barabaka\Entity\Product;
use Barabaka\Service\Products;
use Barabaka\Service\Paginator;
use Zend\Stdlib\Hydrator;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Barabaka\Display\Display;

class IndexController extends AbstractActionController
{
    public function indexAction() {
    }
    
    public function categoryAction() {
        $category = $this->params()->fromQuery('categ');
        $category_title = ucfirst(str_replace("_", " ", $category));
        $category = strtolower($category);
        
        $display = new Display();   
        
        if ( $_SESSION[$category] ) {
            $products_category_info = $_SESSION[$category];
            
            $pagination_arr = $products_category_info['pagination_arr'];
            
            $page = $products_category_info['page'] ? $products_category_info['page'] : 1;
            $current_sub_category_name = $products_category_info['current_sub_category_name']?$products_category_info['current_sub_category_name']:'All';
            $items_per_page = $products_category_info['items_per_page'] ? $products_category_info['items_per_page'] : 6;
            
            new Container();
            
            ob_start();
            $display->categoryProducts($pagination_arr, $items_per_page, $page);
            $out = ob_get_clean();
        } else {
            $current_sub_category_name = 'All';
            $items_per_page = 6;
            $page = 1;
            $critery = array($category => 'yes');
            
            $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
            $products_manager = new Products($objectManager);
            $paginator = new Paginator();
            
            $products_categ = $products_manager->getProductsBy($critery);
            $pagination_arr = $paginator->pagine_array($products_categ, $items_per_page);
            //echo "<pre>"; var_dump($pagination_arr); die();
            
            ob_start();
            $display->categoryProducts($pagination_arr, $items_per_page, $page);
            $out = ob_get_clean();
        
            new Container();
        }
            
        /*-------------  for debugging  --------------*/
        $_SESSION[$category]['products_var_dump'] = $products_categ;
        $_SESSION[$category]['pagination_arr'] = $pagination_arr;
        /*-------------  for debugging  --------------*/
        
        /*-------------  for displaying  --------------*/
        $_SESSION[$category]['products'] = $out;
        /*-------------  for displaying  --------------*/
        
        /*-------------  for check if new values are differrent with old values  --------------*/
        $_SESSION[$category]['current_sub_category_name'] = $current_sub_category_name;
        $_SESSION[$category]['items_per_page'] = $items_per_page;
        $_SESSION[$category]['sorting_by'] = 'Price';
        $_SESSION[$category]['page'] = $page;
        /*-------------  for check if new values are differrent with old values  --------------*/
        
        $products_category_info = $_SESSION[$category];
        
        $json_products_category = json_encode((array)$pagination_arr);
        $current_session_sorting_by = $_SESSION[$category]['sorting_by'];
        //echo "<pre>"; var_dump($json_session_sorting_by); die();
        
        return array(
            'category' => $category,
            'category_title' => $category_title,
            'products_category_info' => $products_category_info,
            'json_products_category' => $json_products_category,
        );
    }
    
    public function testingAction() {
        //$session_product = new Container();$session_product->getManager()->getStorage()->clear();unset($_SESSION);
        //echo $_SERVER['HTTP_USER_AGENT'] . "\n\n";
            /*
            $category = 'for_decoration';
            
            $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
            $products_manager = new Products($objectManager);
            
            $critery = array($category => 'yes');
            $sorting = array('popularity' => 'ASC');
            $products_categ = $products_manager->getProductsBy($critery, $sorting);
            
            echo "<pre>"; print_r($products_categ); die();
            */
    }
}












