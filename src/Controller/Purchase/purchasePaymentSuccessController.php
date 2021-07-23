<?php

namespace App\Controller\Purchase;

use App\Entity\Purchase;
use App\Cart\CartService;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class purchasePaymentSuccessController extends AbstractController
{
    /**
     *  @Route("purchase/terminate/{id}",name="purchase_payment_success")
     *  @IsGranted("ROLE_USER")
     */
    public function success($id,PurchaseRepository $purchaseRepository, EntityManagerInterface $em, CartService $cartService){
        
        $purchase =$purchaseRepository->find($id);

        if(
            !$purchase || ($purchase && $purchase->getUser() !== $this->getUser()) || 
            ($purchase && $purchase->getStatus() === Purchase::STATUS_PAID) )
        {
            $this->addFlash('warning',"la commande nexiste pas");
             return $this->redirectToRoute("purchases_index");


        }


         //changement de status en status=PAID et enregistrement
        $purchase->setStatus(Purchase::STATUS_PAID);
        $em->flush();


        //vider la  panier         
        $cartService->empty();

 
        $this->addFlash('success', "la commande a été payée et confirmée !" );
        return $this->redirectToRoute("purchases_index");


    }
}