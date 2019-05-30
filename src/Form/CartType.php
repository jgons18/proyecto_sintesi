<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Season;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Session\Session;

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameproduct',TextType::class,[
                'required'=>'required',
                'label' => 'Nombre del producto',
                'attr'=>[
                    'readonly' => true,
                    'class'=>'form-username form-control',
                    'placeholder'=>'ej:Melocotón'
                ]
            ])
            ->add('description',TextType::class,[
                'required'=>'required',
                'label' => 'Descripción',
                'attr'=>[
                    'readonly' => true,
                    'class'=>'form-control',
                    'placeholder'=>'ej:El Melocotón es originario de China desde hace 3.000 a. c.'
                ]
            ])
            ->add('unitprice',NumberType::class,[
                'required'=>'required',
                'label' => 'Precio unidad',
                'attr'=>[
                    'readonly' => true,
                    'class'=>'form-control',
                    'placeholder'=>'ej:2.99'
                ]
            ])
            ->add('stock',NumberType::class,[
                'required'=>'required',
                'label' => 'Existencias',
                'attr'=>[
                    'readonly' => true,
                    'class'=>'form-control',
                    'placeholder'=>'ej:100'
                ]
            ])
            ->add('reservedstocks',NumberType::class,[
                'required'=>'required',
                'label' => 'Existencias reservadas',
                'attr'=>[
                    'readonly' => true,
                    'class'=>'form-control',
                    'placeholder'=>'ej:50'
                ]
            ])
            ->add('season',EntityType::class,[
                'required'=>'required',
                'class' => Season::class,
                'label' => 'Temporada',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'ej:1'
                ]
            ])
            ->add('category',EntityType::class,[
                'required'=>'required',
                'class' => Category::class,
                'label' => 'Categoria',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'ej:2'
                ]
            ])
            ->add('quantity',IntegerType::class,[
                'required'=>'required',
                'label' => 'Unidades',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'ej:50'
                ]
            ])

            ->add('save',SubmitType::class, [
                'label' => 'Añadir al carrito',
                'attr'=>[
                    'class' => 'save'
                ]
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
