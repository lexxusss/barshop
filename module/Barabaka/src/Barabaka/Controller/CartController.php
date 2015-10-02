<?php



namespace Barabaka\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

use Barabaka\Display\Display;

class CartController extends AbstractActionController
{
    public function indexAction() {
        die("Cart Controller -> Index Action");
    }
    
    public function addIntoCartAction() {
        if ( $this->getRequest()->isPost() ) {
            $product_into_cart = $this->getRequest()->getPost('product_into_cart');
            $id                = (int)$product_into_cart['id'];
            
            if ( !isset($_SESSION['products_in_cart'][$id]) ) {
                $_SESSION['products_in_cart'][$id] = $product_into_cart;
                
                unset($_SESSION['products_in_cart'][""]);
            } else {
                die("Your product is already in cart.");
            }
        }
        
        die();
    }
    
    public function removeFromCartAction() {
        if ( $this->getRequest()->isPost() ) {
            $product_from_cart = $this->getRequest()->getPost('product_from_cart');
            
            if ( $product_from_cart ) {
                if ( isset($_SESSION['products_in_cart'][$product_from_cart[0]]) ) {
                    unset($_SESSION['products_in_cart'][$product_from_cart[0]]);
                } else {
                    die("Your product is already removed.");
                }
            } else {
                die("This product doesn't exist: {$product_from_cart[0]}.");
            }
        }
        
        die();
    }
    
    public function productsInCartAction() {
        if ( $this->getRequest()->isPost() ) {
            $display = new Display();
            
            $products_in_cart = $this->layout()->products_in_cart;
            
            $display->cartListDropDown($products_in_cart);
        }
        
        die();
    }
}
















