<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 14/05/19
 * Time: 18:56
 */

namespace App\Form;

use App\Entity\Category;
use App\Entity\Season;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;


class ProductType extends AbstractType
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
                'attr'=>['class'=>'jg_input_form',
                    'placeholder'=>'ej:El Melocotón es originario de China desde hace 3.000 a. c.'
                ]
            ])
            ->add('unitprice',NumberType::class,[
                'required'=>'required',
                'label' => 'Precio unidad',
                'attr'=>['class'=>'jg_input_form',
                    'placeholder'=>'ej:2.99',
                    'min' => 1
                ]
            ])
            ->add('stock',NumberType::class,[
                'required'=>'required',
                'label' => 'Existencias',
                'attr'=>[
                    'class'=>'jg_input_form',
                    //'class'=>'form-control am_form_input am_stock',
                    'placeholder'=>'ej:100',
                    'min' => 1
                ]
            ])
            ->add('reservedstocks',NumberType::class,[
                'required'=>'required',
                'label' => 'Existencias reservadas',
                'attr'=>[
                    'class'=>'jg_input_form',
                   // 'class'=>'form-control am_form_input am_stock_reservado',
                    'placeholder'=>'ej:50',
                    'min' => 1
                ]
            ])
            ->add('season',EntityType::class,[
                'required'=>'required',
                'class' => Season::class,
                'label' => 'Temporada',
                'attr'=>['class'=>'jg_input_form',
                    //'class'=>'form-control am_form_input am_temporada',
                    'placeholder'=>'ej:1'
                ]
            ])
            ->add('category',EntityType::class,[
                'required'=>'required',
                'class' => Category::class,
                'label' => 'Categoria',
                'attr'=>['class'=>'jg_input_form',
                    //'class'=>'form-control am_form_input am_categoria',
                    'placeholder'=>'ej:2'
                ]
            ])
            ->add('image',FileType::class,[
                'label' => 'URL imagen',
                'attr'=>['class'=>'jg_input_form',
                    //'class'=>'form-control am_form_input am_ruta_imagen',
                    'placeholder'=>'ej:img/manzana.jpg'
                ]
            ])
            ->add('save',SubmitType::class, [
                'label' => 'Guardar producto',
                'attr'=>[
                    'class' => 'save am_boton_guardar'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>'App\Entity\Product']);
    }
}