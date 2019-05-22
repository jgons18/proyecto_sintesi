<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 22/05/19
 * Time: 17:38
 */

namespace App\Form;

use App\Entity\Detail;
use App\Entity\Product;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;

class OrderrType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id',NumberType::class,[
                'required'=>'required',
                'label' => 'id del producto',
            ])
            ->add('unitprice',NumberType::class,[
                'required'=>'required',
                'label' => 'precio unidad',

            ])
            ->add('save',SubmitType::class, [
                'label' => 'Guardar producto',
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