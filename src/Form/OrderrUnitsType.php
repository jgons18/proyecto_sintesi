<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 01/06/19
 * Time: 17:58
 */

namespace App\Form;

use App\Entity\Detail;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Component\Form\AbstractType;

class OrderrUnitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity',IntegerType::class,[
                'required'=>'required',
                'label' => 'Unidades',
                'attr'=>[
                    'class'=>'jg_input_unidades',
                    'placeholder'=>'ej:50',
                    'min'=>1
                ]
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=> Detail::class]);
    }

}