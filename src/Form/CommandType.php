<?php

namespace App\Form;

use App\Entity\Materiel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class CommandType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresse_email', EmailType::class, [
                'label' => 'Votre adresse Email',
                'label_attr' => [
                    'class' => 'mut'
                ],
                'mapped' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'user@example.com'
                ]
            ])
            ->add('numero', NumberType::class, [
                'label' => 'Numéro Téléphone',
                'label_attr' => [
                    'class' => 'mut'
                ],
                'mapped' => false,
                'required' => true,
                'html5' => true,
                'attr' => [
                    'placeholder' => '+261...'
                ]
            ])
            ->add('nom', EntityType::class, [
                'class' => Materiel::class,
                'choice_label' => function ($materiel) {
                    return $materiel->getNom();
                },
                'label' => 'Les matériels disponible',
                'label_attr' => [
                    'class' => 'mutx'
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => [
                    'class' => 'boutn frombtn w100'
                ]
            ]);
    }
}
