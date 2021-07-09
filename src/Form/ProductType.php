<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Products;
use App\Form\DataTransformer\CentimeTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("Nom",TextType::class,[
            "label"=>"Nom du produit",
            "attr"=>["placeholder"=>"Tapez le nom du produit"],
            "required"=> false
        ])
               ->add("shortDescription",TextareaType::class,[
                   "label"=>"description",
                   "attr"=>[ 
                       "placeholder"=>"tapez un description assez courte mais  parlante pour le visteur"
                   ],
                   "required"=> false
               ])
               ->add("Prix",MoneyType::class,[
                   "label"=>"prix du produit",
                   "attr"=>[   
                       "placeholder"=>"tapez le prix en €"
                   ],
                   'divisor'=>100,
                   "required"=> false
                   ])

                   ->add('mainpicture',UrlType::class,[
                       "label"=>"Image du produit",
                       "attr"=>["placHolder"=>"Taper une Url dimage !"],
                       "required"=> false
                   ])
                   ->add("category",EntityType::class,[
                    "label"=>"catégorie",
                   "placeholder"=>"--choisir une categorie--",
                    "class" => Category::class,
                    "choice_label"=>"name"
                    ]);
                    // $builder->get('prix')->addModelTransformer(new CentimeTransformer);

                //     $builder->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $event){
                   
                //        $product=$event->getData();

                //     if ($product->getPrix() !==null){
                //         $product->setPrix ($product->getPrix()*100);
                //     }
                 

                //     });

                   

                //    $builder->addEventListener(FormEvents::PRE_SET_DATA,function(FormEvent $event){
                //        $form=$event->getForm();

                //        /** @var Products */
                //        $product =$event->getData();
                       
                //        if($product->getPrix() !==null){  

                //       $product->setPrix ($product->getPrix()/100);

                    //    }
                     








                //        if($product->getId()===null){

                //    $form->add("category",EntityType::class,[
                //    "label"=>"catégorie",
                //   "placeholder"=>"--choisir une categorie--",
                //    "class" => Category::class,
                //    "choice_label"=>"name"
                //    ]);
                    //    }

                    

                //    });

                }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
