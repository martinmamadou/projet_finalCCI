<?php

namespace App\Form;

use App\Entity\ExerciceMaison;
use App\Entity\ProgrammeMaison;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExMaisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom Exercice : ",
                'required' => false,
                'attr' => [
                    'placeholder' => 'Pompes...'
                ]
            ])
            ->add('enable', CheckboxType::class, [
                'label' => 'actif',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExerciceMaison::class,
        ]);
    }
}
