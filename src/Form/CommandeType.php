<?php

namespace App\Form;

use App\Entity\Materiel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('nom', EntityType::class, [
            //     'class' => Materiel::class,
            //     'choice_label' => 'nom',
            //     'multiple' => true,
            //     'expanded' => true,
            //     'required' => true,
            //     'label_attr' => [
            //         'class' => 'checkbox-inline'
            //     ]
            // ])
            ->add('nom', EntityType::class,[
               'class' => Materiel::class,
               'choices' => $group->getNom(),
            ])
            ->add('adresse_email', EmailType::class,[
                'label' => 'Adresse Email',
                'mapped' => false,
                'required' => true
            ])
            ->add('numero', NumberType::class,[
                'label' => 'Numéro',
                'mapped' => false,
                'required' => true,
                'html5' => true
            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => Materiel::class,
        ]);
    }
}
