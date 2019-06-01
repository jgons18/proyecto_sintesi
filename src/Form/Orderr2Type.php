<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 23/05/19
 * Time: 18:41
 */

namespace App\Form;

use App\Entity\Carrier;
use App\Entity\Orderr;
use App\Entity\Paymentmethod;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class Orderr2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            /*->add('quantity',IntegerType::class,[
                'required'=>'required',
                'label' => 'Unidades',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'ej:50',
                    'min'=>1
                ]
            ])*/
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
            ->add('nameofowner',TextType::class,[
                'required'=>'required',
                'label' => 'Nombre de la tarjeta',
                'attr'=>[
                    'class'=>'form-control',
                    'pattern'=>'[A-Za-z]{1,150}'
                ]

            ])
            ->add('cardnumber',TextType::class,[
                'required'=>'required',
                'label' => 'Número de tarjeta',
                'attr'=>[
                    'class'=>'form-control',
                    'pattern'=>'{1,16}'
                ]

            ])
            ->add('save',SubmitType::class, [
                'label' => 'Realizar pedido',
                'attr'=>[
                    'class' => 'save'
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=> Orderr::class]);
    }

}