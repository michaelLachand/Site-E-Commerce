<?php


namespace App\Event;


use App\Entity\Product;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\Event;

class ProductViewEvent extends Event
{
    protected $product;

    /**
     * ProductViewEvent constructor.
     * @param Product $product
     */
     function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }




}