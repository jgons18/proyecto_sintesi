<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 23/05/19
 * Time: 18:41
 */

namespace App\Form;

use App\Entity\Carrier;
use App\Entity\Detail;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
                    'placeholder'=>'ej:50'
                ]
            ])

        ->add('Anadir',SubmitType::class, [
        'label' => 'Añadir',
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