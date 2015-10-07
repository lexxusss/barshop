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
        
        new Container();
        
        if ( !$_SESSION[$category]['page'] )
            $_SESSION[$category]['page'] = 1;
            
        if ( !$_SESSION[$category]['sorting_by'] )
            $_SESSION[$category]['sorting_by'] = "Price";
            
        if ( !$_SESSION[$category]['items_per_page'] )
            $_SESSION[$category]['items_per_page'] = 8;
            
        if ( !$_SESSION[$category]['products_var_dump'] ) {
            $critery = array($category => 'yes');
            $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
            $products_manager = new Products($objectManager);
            
            $_SESSION[$category]['products_var_dump'] = $products_manager->getProductsBy($critery);
        }
                
        if ( !$_SESSION[$category]['pagination_arr'] ) {
            $paginator = new Paginator();
            
            $_SESSION[$category]['pagination_arr'] = $paginator->pagine_array($_SESSION[$category]['products_var_dump'], $_SESSION[$category]['items_per_page']);
        }  
                
        if ( !$_SESSION[$category]['products'] ) {
            $display = new Display();
            
            ob_start();
            $display->categoryProducts($_SESSION[$category]['pagination_arr'], $_SESSION[$category]['items_per_page'], $_SESSION[$category]['page']);
            $out = ob_get_clean();
            
            $_SESSION[$category]['products'] = $out;
        }
        
        /*-------get session variables-------*/
        $products_category_info = $_SESSION[$category];
        $json_products_category = json_encode((array)$_SESSION[$category]['pagination_arr']);
        /*-------get session variables-------*/
        
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












