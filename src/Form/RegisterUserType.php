<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class,[
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Imadjakhrouti@gmail.com',
                ]
            ])
            ->add('password', PasswordType::class,[
                'label' => 'Mot de passe',
                'attr' => [
                    'placeholder' => '**********',
                ]
            ])

            ->add('firstname',TextType::class,[
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Imad',
                ]
            ])
            ->add('lastname',TextType::class,[
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Jakhrouti',
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
            'data_class' => User::class,
        ]);
    }
}
