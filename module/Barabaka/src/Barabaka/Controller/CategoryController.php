<?php
namespace Barabaka\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Barabaka\Entity\Product;
use Barabaka\Service\Products;
use Barabaka\Service\Paginator;
use Barabaka\Display\Display;

use Zend\Stdlib\Hydrator;
use Zend\View\Model\JsonModel;
use Zend\Session\Container;
use Zend\Session\SessionManager;

class CategoryController extends AbstractActionController
{
    public function indexAction() {
        die("Category Controller -> Index Action");
    }
    
    public function paginationAction()
    {
        if ( $this->getRequest()->isPost() ) {
            /*-------------  categories  --------------*/
            $category = trim(strtolower($this->getRequest()->getPost('category')));
            /*-------------  categories  --------------*/
            
            /*-------------  sortings  --------------*/
            $sorting_by = trim(strtolower($this->getRequest()->getPost('sorting_by')));
            /*-------------  sortings  --------------*/
            
            /*-------------  filters  --------------*/
            $items_per_page = trim((int)$this->getRequest()->getPost('items_per_page'));
            /*-------------  filters  --------------*/
            
            /*-------------  page  --------------*/
            $page = trim((int)$this->getRequest()->getPost('page'));
            /*-------------  page  --------------*/
            
            $_SESSION[$category]['debug'] = "...:\r\n";
            
            if ( $sorting_by != strtolower($_SESSION[$category]['sorting_by'])
                 ||
                 $items_per_page != $_SESSION[$category]['items_per_page']
                 ||
                 $page != $_SESSION[$category]['page'] )
            {
                $paginator = new Paginator();
                $display = new Display();
                
                /*-------------  check sortings  --------------*/
                if ( $sorting_by == strtolower($_SESSION[$category]['sorting_by']) ) {
                    $products_categ = $_SESSION[$category]['products_var_dump'];
                    $_SESSION[$category]['debug'] .= "sorting_by ==;\r\n";
                } else {
                    switch ($sorting_by) {
                        case 'relevance':
                            $sorting = 'id';
                            break;
                        case 'price':
                            $sorting = 'price_new';
                            break;
                        case 'popularity':
                            $sorting = 'popularity';
                            break;
                        default:
                            $sorting = 'id';
                    }
                    
                    $objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
                    $products_manager = new Products($objectManager);
                    
                    $critery = array($category => 'yes');
                    $sorting = array($sorting => 'ASC');
                    $products_categ = $products_manager->getProductsBy($critery, $sorting);
                    
                    // debugging //
                    ob_start();
                    var_dump($sorting_by);
                    $o = ob_get_clean();
                    
                    $_SESSION[$category]['debug'] .= "sorting_by !=;\r\n".$o;
                    // debugging //
                }
                /*-------------  check sortings  --------------*/
                
                $pagination_arr = $paginator->pagine_array($products_categ, $items_per_page);
                
                if ( !$page ) $page = 1;
                if ( $page > count($pagination_arr) ) $page = count($pagination_arr);
                
                ob_start();
                $display->categoryProducts($pagination_arr, $items_per_page, $page);
                $out = ob_get_clean();
                
                ob_start();
                $display->paginationPages($pagination_arr, $page);
                $pagination_pages = ob_get_clean();
                
                new Container();
                
                /*-------------  for debugging  --------------*/
                $_SESSION[$category]['products_var_dump'] = $products_categ;
                $_SESSION[$category]['pagination_arr'] = $pagination_arr;
                /*-------------  for debugging  --------------*/
                
                /*-------------  for displaying  --------------*/
                $_SESSION[$category]['products'] = $out;
                $_SESSION[$category]['pagination_pages'] = $pagination_pages;
                /*-------------  for displaying  --------------*/
                
                /*-------------  for check if new values are differrent with old values  --------------*/
                $_SESSION[$category]['items_per_page'] = $items_per_page;
                $_SESSION[$category]['sorting_by'] = $this->getRequest()->getPost('sorting_by');
                $_SESSION[$category]['page'] = $page;
                /*-------------  for check if new values are differrent with old values  --------------*/
            } else {
                $_SESSION[$category]['debug'] .= "nothing were changed";
            }
            
            die(json_encode($_SESSION[$category])); // for parsing by JS
        }
        die('No data! Need POST!');
    }
}
