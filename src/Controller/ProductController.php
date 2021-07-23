<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Products;
use App\Form\ProductType;
use App\Repository\CategoryRepository;
use App\Repository\ProductsRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
    /**
     * @Route("/{slug}", name="product_category",priority=-1)
     */
    public function category($slug , CategoryRepository $categoryRepository)
    {
        $category=$categoryRepository->findOneBy([
            'slug'=>$slug
        ]);

        if(!$category){
          throw $this->createNotFoundException("la categorie nexiste pas");
        }


        return $this->render('product/category.html.twig', [
            'slug' => $slug,
            'category'=> $category
        ]);
    }
 /**
 * @Route("/{category_slug}/{slug}", name="product_show", priority=-1)
 */
    public function show($slug, ProductsRepository $productsRepository){

   

        $product= $productsRepository->findOneBy([
            'slug'=>$slug
        ]);

        if(!$product){

            throw $this->createNotFoundException("le produit demandé n'exsite pas");
        }

        return $this->render("product/show.html.twig",[
            'product'=>$product
           
        ]);
    }
     /**
      * @Route("/admin/product/{id}/edit", name="product_edit")
      */
    public function edit($id,ProductsRepository $productsRepository, Request $request,EntityManagerInterface $em,ValidatorInterface $validator)
    {
       
        

        $product =$productsRepository->find($id);

        $form=$this->createForm(ProductType::class,$product);
          
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            
                    
                    return $this->redirectToRoute("product_show",[
                        "category_slug"=> $product->getCategory()->getSlug(),
                            "slug"=> $product->getSlug()]);

            
        }
        // $form->setData($product);

        $formView=$form->createView();

        return $this->render("product/edit.html.twig",[
        "product"=>$product,
        "formView"=>$formView
        


        ]);

    }


    /**
     * @Route("/admin/product/create",name="product_create")
     */
    public function create (Request $request,SluggerInterface $slugger,EntityManagerInterface $em )
    {
      
        $product=new Products;

         $form =$this->createForm(ProductType::class,$product);
     

                

                $form->handleRequest($request);
                

                if($form->isSubmitted()&& $form->isValid()){
                
                    $product->setSlug(strtolower($slugger->slug($product->getNom())));

                    $em->persist($product);
                    $em->flush();
                    return $this->redirectToRoute("product_show",[
                        "category_slug"=> $product->getCategory()->getSlug(),
                            "slug"=> $product->getSlug()]);
                    
                }

          

                $formView= $form->createView();

        


         return $this->render('product/create.html.twig',[
            'formView'=> $formView
        ]);
    }

}
