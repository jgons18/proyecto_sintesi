<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 24/05/19
 * Time: 15:50
 */

namespace App\Form;


use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Season;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductBoxEditType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nameproduct',TextType::class,[
                'required'=>'required',
                'label' => 'Nombre del producto',
                'attr'=>[
                    'class'=>'jg_input_form',
                    'placeholder'=>'ej:Melocotón'
                ]
            ])
            ->add('description',TextType::class,[
                'required'=>'required',
                'label' => 'Descripción',
                'attr'=>[
                    'class'=>'jg_input_form',
                    'placeholder'=>'ej:El Melocotón es originario de China desde hace 3.000 a. c.'
                ]
            ])
            ->add('unitprice',NumberType::class,[
                'required'=>'required',
                'label' => 'Precio unidad',
                'attr'=>[
                    'class'=>'jg_input_form',
                    'placeholder'=>'ej:2.99'
                ]
            ])
            ->add('stock',NumberType::class,[
                'required'=>'required',
                'label' => 'Existencias',
                'attr'=>[
                    'class'=>'jg_input_form',
                    'placeholder'=>'ej:100'
                ]
            ])
            ->add('reservedstocks',NumberType::class,[
                'required'=>'required',
                'label' => 'Existencias reservadas',
                'attr'=>[
                    'class'=>'jg_input_form',
                    'placeholder'=>'ej:50'
                ]
            ])
            ->add('season',EntityType::class,[
                'required'=>'required',
                'class' => Season::class,
                'label' => 'Temporada',
                'attr'=>[
                    'class'=>'jg_input_form',
                    'placeholder'=>'ej:1'
                ]
            ])
            /*->add('category',EntityType::class,[
                'required'=>'required',
                'class' => Category::class,
                'label' => 'Categoria',
                'attr'=>[
                    'class'=>'jg_input_form',
                    'readonly' => true,
                ]
            ])*/
            /*->add('image',TextType::class,[
                'label' => 'URL imagen',
                'attr'=>[
                    'class'=>'jg_input_form',
                    'placeholder'=>'ej:iframe',
                    "data_class" =>null
                ]
            ])*/
            //->add('image',FileType::class,array('data_class'=> null))
            ->add('save',SubmitType::class, [
                'label' => 'Actualizar producto',
                'attr'=>[
                    'class' => 'save'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=> Product::class]);
    }
}