<?php
/**
 * Created by PhpStorm.
 * User: linux
 * Date: 13/05/19
 * Time: 17:16
 */

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

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //función para construir un formulario
        //añadimos add por tantos campos que tengamos en la clase User(en entity)
        $builder
            /*->add('username',TextType::class,[
                'required'=>'required',
                'label' => 'Nombre de usuario',
                'attr'=>[
                    'class'=>'jg_input_form',
                    'placeholder'=>'ej:usuario123',
                    'pattern' => '^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$'
                ]
            ])*/
            ->add('email',EmailType::class,[
                'required'=>'required',
                'label' => 'Correo electrónico',
                'attr'=>[
                    'class'=>'jg_input_form',
                    'placeholder'=>'Email@email'
                ]
            ])
            ->add('plainpassword',RepeatedType::class,[ //repeated por que se repetirá para comparar con otro campo de password de que son iguales
                'type'=>PasswordType::class, //aqui indicamos que tipo de campo se va  repetir
                'required'=>'required',
                'first_options'=>[
                    'label' => 'Contraseña',
                    'attr'=>[
                        'class'=>'jg_input_form',
                        'placeholder'=>'Introduzca la contraseña',
                    ]
                ],
                'second_options'=>[
                    'label' => 'Repita la contraseña',
                    'attr'=>[
                        'class'=>'jg_input_form',
                        'placeholder'=>'Repite la contraseña'
                    ]
                ]

            ])
            ->add('name',TextType::class,[
                'required'=>'required',
                'label' => 'Nombre',
                'attr'=>[
                    'class'=>'jg_input_form',
                    'placeholder'=>'ej:Maria',
                    'pattern'=>'[A-Za-z]{1,40}'
                ]
            ])
            ->add('surname',TextType::class,[
                'required'=>'required',
                'label' => 'Apellidos',
                'attr'=>[
                    'class'=>'jg_input_form',
                    'placeholder'=>'ej:Gómez Roca',
                    'pattern'=>'[A-Za-z]{1,100}'
                ]
            ])
            ->add('address',TextType::class,[
                'required'=>'required',
                'label' => 'Dirección',
                'attr'=>[
                    'class'=>'jg_input_form',
                    'placeholder'=>'ej:C/de las flores,44',
                    'pattern'=>'[A-Za-z0-9]'
                ]
            ])
            ->add('city',TextType::class,[
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
            ->add('province',TextType::class,[
                'required'=>'required',
                'label' => 'Provincia',
                'attr'=>[
                    'class'=>'jg_input_form',
                    'placeholder'=>'ej:Barcelona',
                    'pattern'=>'[A-Za-z]{1,20}'
                ]
            ])

            ->add('save',SubmitType::class, [
                'label' => 'Registrarme',
                'attr'=>[
                    'class' => 'save'
                ]
            ]);
/*<<<<<<< HEAD
=======
            /*->add('username',TextType::class,[
                'required'=>'required',
                'label' => 'Nombre de usuario',
                'attr'=>[
                    'class'=>'form-username form-control',
                    'placeholder'=>'ej:usuario123'
                ]
            ])
            ->add('email',EmailType::class,[
                'required'=>'required',
                'label' => 'Correo electrónico',
                'attr'=>[
                    'class'=>'form-email form-control',
                    'placeholder'=>'Email@email'
                ]
            ])
            ->add('plainpassword',RepeatedType::class,[ //repeated por que se repetirá para comparar con otro campo de password de que son iguales
                'type'=>PasswordType::class, //aqui indicamos que tipo de campo se va  repetir
                'required'=>'required',
                'first_options'=>[
                    'label' => 'Contraseña',
                    'attr'=>[
                        'class'=>'form-password form-control',
                        'placeholder'=>'Introduzca la contraseña',
                    ]
                ],
                'second_options'=>[
                    'label' => 'Repita la contraseña',
                    'attr'=>[
                        'class'=>'form-password form-control',
                        'placeholder'=>'Repite la contraseña'
                    ]
                ]

            ])
>>>>>>> e4831df8f4cac621807ad401edc06bd44d973c74*/
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>'App\Entity\User']);
    }
}