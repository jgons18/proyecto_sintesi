<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 15/05/19
 * Time: 16:44
 */

namespace App\Form;


use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Offer;
use App\Entity\Season;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AplyoferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('offer',EntityType::class,[
                'class' =>Offer::class,
                'label' => 'Oferta',
                'attr'=>[
                    'class'=>'jg_input_form',
                    'placeholder'=>'ej:2'
                ]
            ])
            ->add('image',FileType::class,array('data_class'=> null))
            ->add('save',SubmitType::class, [
                'label' => 'Aplicar oferta',
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