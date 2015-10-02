<?php

namespace Barabaka\Service;

use Barabaka\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Stdlib\Hydrator;

class Products
{
    protected $objectManager;
    protected $hydrator;
    
    public function __construct(EntityManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->hydrator = new Hydrator\ArraySerializable();
    }
    
    public function fetchAll()
    {
        $product = new Product();
        
        $products = array();
        for ( $i = 1; $products[$i] = $this->objectManager->find('Barabaka\Entity\Product', $i); $i++ );
        array_pop($products);
        
        return $products;
    }
    
    public function getProductsBy($critery = array(), $orderBy = null, $limit = null, $offset = null) {
        $products = $this->objectManager->getRepository("Barabaka\Entity\Product")->findBy($critery, $orderBy, $limit, $offset);
        
        $products_arr     = array();
        foreach ( $products as $id => $product ) {
            $products_arr[$id] = $this->hydrator->extract($product);
        }
         
        return $products_arr;
    }
}