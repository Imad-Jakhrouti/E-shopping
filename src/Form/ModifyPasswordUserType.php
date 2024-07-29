<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ModifyPasswordUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('actualPassword', PasswordType::class, [
//                'label' => 'Mot de passe actuel',
                'label_attr' => ['class' => 'd-none'],
                'attr' => [
                    'placeholder' => 'Taper votre Mot de passe actuel',
                    'class' => 'my_input'
                ],

                'mapped' => false,

            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,

                'first_options'  => [
//                    'label' => 'Mot de passe',
                    'label_attr' => ['class' => 'd-none'],
                    'hash_property_path' => 'password',
                    'attr' => [
                        'placeholder' => 'Taper votre nouveau Mot de passe',
                        'class' => 'my_input'
                    ]

                ],
                'second_options' => [
//                    'label' => 'Confirmer mot de passe',
                    'label_attr' => ['class' => 'd-none'],
                    'attr' => [
                        'placeholder' => 'Confirmer votre nouveau mot de passe',
                        'class' => 'my_input'

                    ]
                ],
                'mapped' => false,
            ])
            ->add('Submit',SubmitType::class , [
                'label' => 'Mettre a jour',
                'attr' => [
                    'class' => 'my_button btn'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
