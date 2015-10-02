<?php

namespace Barabaka\Entity;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @ORM\Entity
 * @ORM\Table(name="products")
 */
class Product {
    /**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;

    /** @ORM\Column(type="string") */
    protected $name;

    /** @ORM\Column(type="string") */
    protected $price_old;

    /** @ORM\Column(type="string") */
    protected $price_new;

    /** @ORM\Column(type="string") */
    protected $sale_cool;

    /** @ORM\Column(type="string") */
    protected $img;

    /** @ORM\Column(type="string") */
    protected $for_decoration;

    /** @ORM\Column(type="string") */
    protected $for_kitchen;

    /** @ORM\Column(type="string") */
    protected $for_you;

    /** @ORM\Column(type="string") */
    protected $popularity;
    
    public function getId() {
        return $this->id;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getPriceOld() {
        return $this->price_old;
    }
    
    public function setPriceOld($price_old) {
        $this->price_old = $price_old;
    }
    
    public function getPriceNew() {
        return $this->price_new;
    }
    
    public function setPriceNew($price_new) {
        $this->price_new = $price_new;
    }
    
    public function getSaleCool() {
        return $this->sale_cool;
    }
    
    public function setSaleCool($sale_cool) {
        $this->sale_cool = $sale_cool;
    }
    
    public function getImg() {
        return $this->img;
    }
    
    public function setImg($img) {
        $this->img = $img;
    }

    public function getPopularity() {
        return $this->popularity;
    }

    public function setPopularity($popularity) {
        $this->popularity = $popularity;
    }

    /**
     * @return mixed
     */
    public function getForDecoration() {
        return $this->for_decoration;
    }

    /**
     * @param mixed $for_decoration
     */
    public function setForDecoration($for_decoration) {
        $this->for_decoration = $for_decoration;
    }

    /**
     * @return mixed
     */
    public function getForKitchen() {
        return $this->for_kitchen;
    }

    /**
     * @param mixed $for_kitchen
     */
    public function setForKitchen($for_kitchen) {
        $this->for_kitchen = $for_kitchen;
    }

    /**
     * @return mixed
     */
    public function getForYou() {
        return $this->for_you;
    }

    /**
     * @param mixed $for_you
     */
    public function setForYou($for_you) {
        $this->for_you = $for_you;
    }
    
    public function getArrayCopy() {
        return get_object_vars($this);
    }
}



















