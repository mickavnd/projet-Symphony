<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class TestController extends AbstractController
{
  

    // /**
    //  * @Route("/", name="home")
    //  */
    // public function home(){

    //  // return new Response("bonjour");

    // }
    /**
     * @Route("/hello/{prenom?world}",name="hello")
     */
    public function hello($prenom = "world")
    {

     
        return $this->render('hello.html.twig',[
            'prenom'=>$prenom
        ]);
     
  


    //    dump($detector->detect((130)));
    //    dump($detector->detect((80)));
        
    //     dump($slugify->slugify("hello world"));



    //     $tva =$this->calculator->calcul(100);
    //     dump($tva);

        
    }
    /**
     * @Route("/example", name="example")
     */
    public function example(){

        return $this->render('example.html.twig',[
            'age'=>33
        ]);

}

}