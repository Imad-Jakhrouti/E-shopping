<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,[
//                'label' => 'Prenom',
                'label_attr' => ['class' => 'd-none'],
                'attr' => [
                    'placeholder' => 'Prenom',
                    'class' => 'my_input'
                ]
            ])
            ->add('lastname', TextType::class,[
//                'label' => 'Nom',
                'label_attr' => ['class' => 'd-none'],
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'my_input'
                ]
            ])
            ->add('address', TextType::class,[
//                'label' => 'Adresse',
                'label_attr' => ['class' => 'd-none'],
                'attr' => [
                    'placeholder' => 'Adresse',
                    'class' => 'my_input'
                ]
            ])
            ->add('postal', TextType::class,[
//                'label' => 'Code Postal',
                'label_attr' => ['class' => 'd-none'],
                'attr' => [
                    'placeholder' => 'Code Postal',
                    'class' => 'my_input'
                ]
            ])
            ->add('city', TextType::class,[
//                'label' => 'ville',
                'label_attr' => ['class' => 'd-none'],
                'attr' => [
                    'placeholder' => 'Ville',
                    'class' => 'my_input'
                ]
            ])
            ->add('country', CountryType::class,[
//                'label' => 'Pays' ,
                'label_attr' => ['class' => 'd-none'],
                'attr' => [
                    'placeholder' => 'Ville',
                    'class' => 'my_input'
                ]
            ])
            ->add('phone' , TextType::class,[
//                'label' => 'Numero de telephone' ,
                'label_attr' => ['class' => 'd-none'],
                'attr' => [
                    'placeholder' => 'Numero du telephone',
                    'class' => 'my_input'
                ]
            ])
            ->add('Submit',SubmitType::class , [
                'label' => 'Ajouter',
                'attr' => [
                    'class' => 'my_button btn w-100'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
