<?php

namespace App\Form;

use App\Entity\ExerciceMaison;
use App\Entity\Exercices;
use App\Entity\Programme;
use App\Entity\ProgrammeMaison;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExMaisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('enable', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false
            ]);

        if ($options['isAdmin']) {
            $builder

                ->add('programme', CollectionType::class, [
                    'label' => 'Exercice',
                    'entry_type' => EntityType::class,
                    'entry_options' => [
                        'class' => Exercices::class,
                        'choice_label' => 'name'
                    ],

                ])
                ->add('repetition', NumberType::class, [
                    'label' => 'Répétition',
                    'required' => false,
                ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercices::class,
            'isAdmin' => true
        ]);
    }
}
