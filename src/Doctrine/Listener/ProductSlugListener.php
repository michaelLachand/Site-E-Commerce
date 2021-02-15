<?php

namespace App\Doctrine\Listener;

use App\Entity\Product;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductSlugListener
{
    protected $slugger;

    /**
     * ProductSlugListener constructor.
     * @param $slugger
     */
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }


    public function prePersist(Product $entity, LifecycleEventArgs $event)
    {
       if(empty($entity->getSlug())){
           $entity->setSlug(strtolower($this->slugger->slug($entity->getName())));
       }
    }
}
