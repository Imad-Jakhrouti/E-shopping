<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Imadjakhrouti@gmail.com',
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'attr' =>[
                      'placeholder' => 'Taper votre Mot de passe',
                    ],
                    'constraints' => [
                        new Length([
                            'min' => 8,
                            'max' => 50,
                        ])
                    ],
                    'hash_property_path' => 'password',
                ],
                'second_options' => [
                    'label' => 'Confirmation mot de passe',
                    'attr' =>[
                        'placeholder' => 'Taper votre Mot de passe',
                    ],
                ],
                'mapped' => false,
            ])

            ->add('firstname',TextType::class,[
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Imad',
                ],
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 50,
                    ])
                ]
            ])
            ->add('lastname',TextType::class,[
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Jakhrouti',
                ],
                'constraints' => [
                    new Length([
                        'min' => 2,
                        'max' => 50,
                    ])
                ]
            ])
            ->add('Inscrire', SubmitType::class,[
                'attr' =>[
                    'class' => 'btn btn-success'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'constraints' => [
                new UniqueEntity([
                    'entityClass' => User::class, // c'est oblige puisque la formulaire est deja lie avec l'entite User
                    'fields' => 'email',
                    'message' => 'Cette adresse email est déjà utilisée.',
                ])
            ],
            'data_class' => User::class,
        ]);
    }
}
