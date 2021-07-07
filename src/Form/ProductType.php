<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Products;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("Nom",TextType::class,[
            "label"=>"Nom du produit",
            "attr"=>["placeholder"=>"Tapez le nom du produit"]
        ])
               ->add("shortDescription",TextareaType::class,[
                   "label"=>"description",
                   "attr"=>[ 
                       "placeholder"=>"tapez un description assez courte mais  parlante pour le visteur"
                   ]
               ])
               ->add("prix",MoneyType::class,[
                   "label"=>"prix du produit",
                   "attr"=>[   
                       "placeholder"=>"tapez le prix en €"
                   ]
                   ])

                   ->add('mainPicture',UrlType::class,[
                       "label"=>"Image du produit",
                       "attr"=>["placHolder"=>"Taper une Url dimage !"]
                   ])

                   ->add("category",EntityType::class,[
                   "label"=>"catégorie",
                  "placeholder"=>"--choisir une categorie--",
                   "class" => Category::class,
                   "choice_label"=>"name"
                   ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
