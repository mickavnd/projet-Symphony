<?php

namespace App\Cart ;

use App\Repository\ProductsRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class CartService 
{
    protected $session;
    protected $productsRepository;

    public function __construct(SessionInterface $session,ProductsRepository $productsRepository)
    {
        $this->session=$session;
        $this->productsRepository=$productsRepository;
        
    }

    protected function getCarte(): array{
        return $this->session->get('carte',[]);
    }

    protected function saveCarte(array $cart)
    {
        $this->session->set('carte',$cart);
    }

      public function empty()
      {
          $this->saveCarte([]);
      }

    public function add(int $id)
    {
         // 1. retrouver le panier dans la seesion (sous forme de tableau)

      //2. si il nexste pas encore ,alors prendre un tableau vide 

      $cart= $this->getCarte();

      //3 voir si le produit ($id) existe deja dans le tableau
      //4 si cest le cas simplement augmenter la qualité
      //5 sinon ajouter le produit avec la quantité 1
      if (!array_key_exists($id,$cart))
      {
          $cart[$id] = 0 ;
      }
          $cart[$id]++;
      

      
      //6.enregisté le tableau mis a jour dans  la session

     $this->saveCarte($cart);
    } 

    public function getTotal() : int
    {  $total=0;
        foreach($this->getCarte() as $id => $qty){
            $product = $this->productsRepository->find($id);
   
            $total +=($product->getPrix() * $qty);
    }
   
           return $total;
           }


public function remove( int $id)
{
    $cart =$this->session->get('carte',[]);
   
    unset($cart[$id]);

    $this->saveCarte($cart);
} 

public function decrement(int $id)
{
    $cart= $this->getCarte();

    if(!array_key_exists($id,$cart)){
        return;
    }

    //soit le produit est a 1 alors il daut simplment le supprimer

    if ($cart[$id] === 1)
    {
      $this->remove($id);
      return;
    }


    //soit le produit est a plus de 1 alors il faut décrementer

    $cart[$id]--;

    $this->saveCarte($cart);


}
      
/**
 * @return CartItem[]
 */
    public function getDetailed():array
{
    $detailedCart=[];
      

        foreach($this->session->get('carte',[]) as $id => $qty){
         $product = $this->productsRepository->find($id);

         if(!$product){
             continue;
         }

            $detailedCart[]= new Cartitems($product,$qty);
            
        
        }
 return $detailedCart;
}




}