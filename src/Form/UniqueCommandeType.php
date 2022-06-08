<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UniqueCommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresse_email', EmailType::class, [
                'label' => 'Votre Adresse Email',
                'label_attr' => [
                    'class' => 'mut'
                ],
                'mapped' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'user@example.com',
                    'class' => 'form-control'
                ]
            ])
            ->add('numero', NumberType::class, [
                'label' => 'Votre numéro',
                'label_attr' => [
                    'class' => 'mut'
                ],
                'mapped' => false,
                'required' => true,
                'html5' => true,
                'attr' => [
                    'placeholder' => '+261...',
                    'class' => 'form-control'
                ]
            ])
            ->add('Valider', SubmitType::class,[
                'attr' => [
                    'class' => 'boutn frombtn w100'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
