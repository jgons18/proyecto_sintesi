<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 24/05/19
 * Time: 15:32
 */

namespace App\Form;

use App\Entity\Category;
use App\Entity\Season;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class ProductBoxType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameproduct',TextType::class,[
                'required'=>'required',
                'label' => 'Nombre del producto',
                'attr'=>[
                    'class'=>'form-username form-control',
                    'placeholder'=>'ej:Melocotón'
                ]
            ])
            ->add('description',TextType::class,[
                'required'=>'required',
                'label' => 'Descripción',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'ej:El Melocotón es originario de China desde hace 3.000 a. c.'
                ]
            ])
            ->add('unitprice',NumberType::class,[
                'required'=>'required',
                'label' => 'Precio unidad',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'ej:2.99'
                ]
            ])
            ->add('stock',NumberType::class,[
                'required'=>'required',
                'label' => 'Existencias',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'ej:100'
                ]
            ])
            ->add('reservedstocks',NumberType::class,[
                'required'=>'required',
                'label' => 'Existencias reservadas',
                'attr'=>[
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
                'class' => Category::class,
                'label' => 'Categoria',
                'attr'=>[
                    'class'=>'form-control',
                    'choice_value'=>4
                ]
            ])
            ->add('image',FileType::class,[
                'label' => 'URL imagen',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'ej:img/manzana.jpg'
                ]
            ])
            ->add('save',SubmitType::class, [
                'label' => 'Guardar producto',
                'attr'=>[
                    'class' => 'save'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>'App\Entity\Product']);
    }
}