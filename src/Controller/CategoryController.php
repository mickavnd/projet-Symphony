<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManager;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CategoryController extends AbstractController
{
    /**
     * @Route("/admin/category/create", name="category_create")
     */
    public function create(Request $request, SluggerInterface $slugger,EntityManagerInterface $em, ValidatorInterface $Validator)
    { 
      



        $category= new Category;

        $form= $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){

            $category->setSlug(strtolower($slugger->slug($category->getName())));
            
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute("homePage");


        }
        $formView= $form->createView();

        return $this->render('category/createCategory.html.twig', [
            'controller_name' => 'CategoryController',
            'formView'=> $formView
        ]);
    }
/**
 * @Route("/admin/category/{id}/edit",name="category_edit")

 *
 */
    public function edit($id,CategoryRepository $categoryRepository,Request $request, EntityManagerInterface $em,Security $security)
    {
      

    //   $this->denyAccessUnlessGranted("ROLE_ADMIN",null,"vous navez pas le droit d'accéder a cette ressource");


    //    $user= $this->getUser();

    //    if($user===null)
    //    {
    //        return $this->redirectToRoute('security_login');
    //    }

    //     if($this->isGranted("ROLE_ADMIN")=== false)
    //     {
    //         throw new AccessDeniedException("vous n'avez pas le droit daccéder a cette ressoource");
    //     }

        $category= $categoryRepository->find($id);

        // if(!$category){
        //     throw new NotFoundHttpException(" cette categorie nexiste pas ");

        //  }


        //  $this->denyAccessUnlessGranted('CAN_EDIT',$category,"vous nete pas le proprietaire  de cette article ");
        //  $user =$this->getUser();
        //   if(!$user){

        //     return $this->redirectToRoute("security_login");
        //  }

        //  if ($user !== $category->getOwner()){
        //      throw new AccessDeniedHttpException("vous n'etes pas le propiétaire de cette categorie");
        //  }


    

        $form =$this->createForm(CategoryType::class,$category);

        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $em-> flush();

            return $this->redirectToRoute("homePage");

        }



        $formView= $form->createView();



        return $this->render("category/edit.html.twig",[
        "category" => $category,
        "formView"=>$formView
        ]);


    }
}
