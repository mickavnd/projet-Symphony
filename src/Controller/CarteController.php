<?php

namespace App\Controller;

use App\Cart\CartService;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CarteController extends AbstractController
{
    protected $productsRepository;
    protected $cartService;

    public function __construct(ProductsRepository $productsRepository , CartService $cartService)
    {
        $this->productsRepository=$productsRepository;
        $this->cartService=$cartService;
    }

    /**
     * @Route("/carte/add/{id}", name="carte_add", requirements={"id":"\d+"})
     */
    public function add($id , Request $request)
    {
      // 0 securisation esque  produit exsite ?
      $product= $this->productsRepository->find($id);

      if(!$product)
      {
          throw $this->createNotFoundException( "le produit $id n'existe pas !");
      }
      
      $this->cartService->add($id);

       $this->addFlash('success',"le produit a bien ete ajoute au panier");
    //   $flashBag->add('success'," le produit a bien etait ajouté au panier");
      
     if($request->query->get('returnToCarte')){
         return $this->redirectToRoute("carte_show");
     }

      return $this-> redirectToRoute('product_show',[
          'category_slug'=>$product->getCategory()->getSlug(),
          'slug'=>$product->getSlug()
      ]);




    }

/**
 * @Route("/carte",name="carte_show")
 */
    public function show()
    {
        $detailedCart = $this->cartService->getDetailed();

        $total=$this->cartService->getTotal();


   
        return $this->render('carte/index.html.twig',[
            'items'=> $detailedCart,
            'total'=> $total
        ]);
    }
/**
 * @Route("/carte/delete/{id}", name="carte_delete" ,requirements={"id": "\d+"})
 */
    public function delete($id )
    {
      $product =$this->productsRepository->find($id);

      if(!$product){
           throw $this->createNotFoundException("le  produit $id n'existe pas et ne peut pas etre suprimé !");
      }

      $this->cartService->remove($id);

      $this->addFlash('success', "le produit a bien ete supprimé du panier");

      return$this->redirectToRoute("carte_show");

    }

/**
 * @Route("/cart/decrement/{id}", name="carte_decrement", requirements={"id" : "\d+"})
 */
    public function decrement( $id )
    {
        $product= $this->productsRepository->find($id);

      if(!$product)
      {
          throw $this->createNotFoundException( "le produit $id n'existe pas !");
      }
      $this->cartService->decrement($id);
      
       $this ->addFlash("success", "le produit a& bien ete decrementé");

       return $this->redirectToRoute("carte_show");

      
    }
        

}