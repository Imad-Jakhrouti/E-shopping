<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('addresses', EntityType::class,[
                'label' => 'Choisis votre adresse de livraison',
                'class' => Address::class,
                'required' => true,
                'expanded' => true,
                'choices' => $options['addresses'],
                'label_html' => true
            ])
            ->add('carriers', EntityType::class,[
                'label' => 'Choisis votre Transporteur',
                'class' => Carrier::class,
                'required' => true,
                'expanded' => true,
                'label_html' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'valider',
                'attr' => [
                    'class' => 'my_button w-100'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'addresses' => null,
            'carriers' => null,
        ]);
    }
}