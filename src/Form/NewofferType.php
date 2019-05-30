<?php

namespace App\Form;

use App\Entity\Offer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class NewofferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        ->add('name',EntityType::class,[
        'required'=>'required',
        'class' => Offer::class,
        'label' => 'Nombre de la oferta',
        'attr'=>[
            'class'=>'form-control am_temporada',
            'placeholder'=>'ej:1'
        ]
    ])
        ->add('discount',NumberType::class,[
            'required'=>'required',
            'class' => Offer::class,
            'label' => 'Descuento',
            'attr'=>[
                'class'=>'form-control am_categoria',
                'placeholder'=>'01/01/2020'
            ]
        ])
        ->add('datestart',DateTimeType::class,[
            'required'=>'required',
            'class' => Offer::class,
            'label' => 'fecha inicio',
            'attr'=>[
                'class'=>'form-control am_categoria',
                'placeholder'=>'05/01/2020'
            ]
        ])
        ->add('datefinish',DateTimeType::class,[
            'required'=>'required',
            'class' => Offer::class,
            'label' => 'fecha final',
            'attr'=>[
                'class'=>'form-control am_categoria',
                'placeholder'=>'ej:2'
            ]
        ])
        ->add('save',SubmitType::class, [
            'label' => 'Guardar Oferta',
            'attr'=>[
                'class' => 'save'
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
