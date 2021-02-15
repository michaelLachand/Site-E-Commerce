<?php


namespace App\Cart;


use App\Entity\Product;

class CartItem
{
    public $product;
    public $qty;

    /**
     * CartItem constructor.
     * @param $product
     * @param $qty
     */
    public function __construct(Product $product,int $qty)
    {
        $this->product = $product;
        $this->qty = $qty;
    }

    public function getTotal(): int
    {
        return $this->product->getPrice() * $this->qty;
    }

}