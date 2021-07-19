<?php

namespace App\Cart;

use App\Entity\Products;

class Cartitems 
{
    public $product;
    public $qty;

    public function __construct(Products $product, int $qty)
    {
        $this->product =$product;
        $this->qty= $qty;
        
    }

    public function getTotal() :int 
    {
         return $this->product->getPrix() * $this->qty;
    }
}