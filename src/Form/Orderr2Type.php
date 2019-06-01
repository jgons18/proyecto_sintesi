<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 23/05/19
 * Time: 18:41
 */

namespace App\Form;

use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Detail;
use App\Entity\Paymentmethod;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class Orderr2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity',IntegerType::class,[
                'required'=>'required',
                'label' => 'Unidades',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'ej:50',
                    'min'=>1
                ]
            ])
            ->add('carrier',EntityType::class,[
                'required'=>'required',
                'class' => Carrier::class,
                'label' => 'Transportistas',
                'multiple'  => false,
                'expanded'  => true,
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'ej:50'
                ]

            ])
            ->add('paymentmethod',EntityType::class,[
                'required'=>'required',
                'class' => Paymentmethod::class,
                'label' => 'Método de pago',
                'multiple'  => false,
                'expanded'  => true,
                'attr'=>[
                    'class'=>'form-control'
                ]

            ])
            ->add('save',SubmitType::class, [
                'label' => 'Guardar pedido',
                'attr'=>[
                    'class' => 'save'
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=> Detail::class]);
    }

}