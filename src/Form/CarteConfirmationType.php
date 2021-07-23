<?php

namespace App\Form;

use App\Entity\Purchase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CarteConfirmationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName',TextType::class,[
                'label'=>'Nom complet',
                'attr'=>[
                    'placeholder'=>'nom complet pour la livraison'
                ] 
            ])
            ->add('address',TextareaType::class,[
                'label'=> 'adresse complete',
                'attr'=>[
                    'placeholder'=>'adresse complete pour la livraison'
                ]

            ])

            ->add('postalCode',TextType::class,[
                'label'=>'code postal',
                'attr'=>[
                    'placeholder'=>'codec postal pour livraison'
                ] 
            ])
            ->add('city',TextType::class,[
                'label'=>'ville',
                'attr'=>[
                    'placeholder'=>'ville pour la livraison'
                ] 
            ])
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class'=>Purchase::class
        ]);
    }
}
