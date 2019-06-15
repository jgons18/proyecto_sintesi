<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Symfony\Component\Validator\Tests\Constraints\choice_callback;

class EditUserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //función para construir un formulario
        //añadimos add por tantos campos que tengamos en la clase User(en entity)

        $provinces = json_decode(file_get_contents("json/provincias.json"), TRUE);
        $provincesChoices = array();

        foreach ($provinces as $province){
            $provincesChoices[$province['nombre']] = $province['provincia_id'];

        }

        $cities = json_decode(file_get_contents("json/municipios.json"), TRUE);
        $citiesChoices = array();

        foreach ($cities as $city) {
            $citiesChoices[$city['nombre']] = $city['municipio_id'];
        }



        $builder

            ->add('address',TextType::class,[
                'required'=>'required',
                'label' => 'Dirección',
                'attr'=>[
                    'class'=>'jg_input_form',
                    'placeholder'=>'ej:C/de las flores,44'/*,
                    'pattern'=>'[A-za-z]'*/
                ]
            ])

            ->add('province',ChoiceType::class, array(
                'choices' => $provincesChoices
            ),
                [
                    'required'=>'required',
                    'label' => 'Provincia',
                    'attr'=>[
                        'class'=>'form-username form-control',
                        'placeholder'=>'ej:Barcelona'
                    ]
                ])

            ->add('city',ChoiceType::class, array(
                'choices' => $citiesChoices
            ),
                [
                    'required'=>'required',
                    'label' => 'Ciudad',
                    'attr'=>[
                        'class'=>'jg_input_form',
                        'placeholder'=>'ej:Viladecans',
                        'pattern'=>'[A-Za-z]{1,30}'
                    ]
                ])
            ->add('postalcode',TextType::class,[
                'required'=>'required',
                'label' => 'Código postal',
                'attr'=>[
                    'class'=>'jg_input_form',
                    'placeholder'=>'ej:08840',
                    'pattern'=>'[0-9]{5}'
                ]
            ])

            ->add('save',SubmitType::class, [
                'label' => 'Guardar',
                'attr'=>[
                    'class' => 'save'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>'App\Entity\User']);
    }
}
