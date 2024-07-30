<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
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
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'max' => 30,
                    ])
                ],
                'mapped' => false,

            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'max' => 30,
                    ])
                ],
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
            ->addEventListener(FormEvents::SUBMIT ,function (FormEvent $event) {
                //recuperer la formullaire
                $form = $event->getForm();

                //recuperer l'actual mot de pass
                $actualPassword = $form->get('actualPassword')->getData();

                // recuperer le mot de passe de l'utilisateur connecter
                $user = $form->getData();

                // recuperer l'objet hasher pour comparer les deux mot de pass
                $hasher = $form->getConfig()->getOptions()['hasher'];

                // comparer les mot de passe
                $isValid = $hasher->isPasswordValid(
                    $user,
                    $actualPassword
                );

                if(!$isValid){
                    $form->get('actualPassword')->addError(new FormError('Mot de passe incorrect'));
                }




            })

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'hasher' => null
        ]);
    }
}


