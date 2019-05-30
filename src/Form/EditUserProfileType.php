<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address',TextType::class,[
                'required'=>'required',
                'label' => 'Dirección',
                'attr'=>[
                    'class'=>'form-username form-control'
                ]
            ])
            ->add('postalcode',TextType::class,[
                'required'=>'required',
                'label' => 'Código postal',
                'attr'=>[
                    'class'=>'form-username form-control'
                ]
            ])
            ->add('city',TextType::class,[
                'required'=>'required',
                'label' => 'Ciudad',
                'attr'=>[
                    'class'=>'form-username form-control'
                ]
            ])
            ->add('province',TextType::class,[
                'required'=>'required',
                'label' => 'Provincia',
                'attr'=>[
                    'class'=>'form-username form-control'
                ]
            ])
            ->add('phone',TextType::class,[
                'label' => 'Telefono',
                'attr'=>[
                    'class'=>'form-username form-control'
                ]
            ])
        ->add('Anadir',SubmitType::class, [
        'label' => 'Añadir',
        'attr'=>[
            'class' => 'sn_editar'
        ]
    ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>'App\Entity\User']);
    }
}
