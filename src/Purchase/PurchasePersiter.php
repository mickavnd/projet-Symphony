<?php

namespace App\Purchase;

use DateTime;
use App\Entity\Purchase;
use App\Cart\CartService;
use App\Entity\PurchaseItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class PurchasePersiter
{
    protected $security;
    protected $cartService;
    protected $em;

    public function __construct(Security $security,CartService $cartService,EntityManagerInterface $em)
    {
        $this->security=$security;
        $this->cartService=$cartService;
        $this->em=$em;
    }


    public function storePurchase(Purchase $purchase){
        $purchase->setUser($this->security->getUser())
        ->setPurchaseAt(new DateTime())
        ->setTotal($this->cartService->getTotal());

    $this->em->persist($purchase);

 
    foreach ($this->cartService->getDetailed() as $cartItem) {
        $purchaseItem = new PurchaseItem;
        $purchaseItem->setPruchase($purchase)
            ->setProduct($cartItem->product)
            ->setProductName($cartItem->product->getPrix())
            ->setQuantity($cartItem->qty)
            ->setTotal($cartItem->getTotal())
            ->setProductPrix($cartItem->product->getPrix());

  

        $this->em->persist($purchaseItem);

       
    }
   $this->em->flush();
}
 

}