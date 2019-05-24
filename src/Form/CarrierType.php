<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 23/05/19
 * Time: 19:41
 */

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class CarrierType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('namecarrier',TextType::class,[
                'required'=>'required',
                'label' => 'Nombre de la empresa',
                'attr'=>[
                    'class'=>'form-control',
                    'placeholder'=>'ej:MRW'
                ]
            ])
            ->add('image',FileType::class,[
                'label' => 'URL logo',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('save',SubmitType::class, [
                'label' => 'Guardar transportista',
                'attr'=>[
                    'class' => 'save'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>'App\Entity\Carrier']);
    }
}