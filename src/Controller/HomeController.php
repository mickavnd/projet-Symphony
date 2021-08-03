<?php
namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="homePage")
     */
    public function homepage(ProductsRepository $productsRepository) {
//   EntityManagerInterface $em
        // $productRepository= $em->getRepository(Product::class);
        //chercher un produit(read)
        // $product= $productRepository->find(2);
        // $product= $productRepository->find(4);
        // $em->remove($product);
        // $em->flush();
        //modifier entité(update)
        // $product->setPrix(2500);
        // $em->flush();
        //ajoutée un produit(create)
        //   $product= new Product;
        //   $product
        //   ->setNom('Table en metal')
        //   ->setPrix(3000)
        //   ->setSlug('table-en metal');
        // $em->persist($product);
        // $em->flush();

        $products= $productsRepository->findBy([],[],4);
        
       
        return $this->render("home.html.twig",[
            'products'=>$products
        ]);

    } 
}