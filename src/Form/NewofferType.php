<?php

namespace App\Form;

use App\Entity\Offer;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Range;

class NewofferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        ->add('name',TextType::class,[
        'required'=>'required',
        'label' => 'Nombre de la oferta',
        'attr'=>[
            'class'=>'jg_input_form',
            'placeholder'=>'ej:1'
        ]
    ])
        ->add('discount',NumberType::class,[
            'required'=>'required',
            'label' => 'Descuento',
            'attr'=>[
                'class'=>'jg_input_form',
                'placeholder'=>'20',
                'min' => '10',
                'max' => '90'
            ]
        ])
        ->add('datestart',DateTimeType::class,[
            'required'=>'required',
            'label' => 'fecha inicio',
            'attr'=>[
                'class'=>'jg_input_foram',
                'placeholder'=>'05/01/2020'
            ]
        ])
        ->add('datefinish',DateTimeType::class,[
            'required'=>'required',
            'label' => 'fecha final',
            'attr'=>[
                'class'=>'jg_input_forma',
                'placeholder'=>'ej:2'
            ]
        ])
        ->add('save',SubmitType::class, [
            'label' => 'Guardar Oferta',
            'attr'=>[
                'class' => 'save sn_s'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
