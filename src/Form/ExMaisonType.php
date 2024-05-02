<?php

namespace App\Form;

use App\Entity\DetailExercice;
use App\Entity\Exercices;
use App\Entity\ExerciceMaison;
use App\Entity\ProgrammeMaison;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ExMaisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'exercice'
            ])
            ->add('enable', CheckboxType::class, [
                'label' => 'actif',
                'required' => false
            ])
            
            ->add('detailExercices', CollectionType::class, [
                'entry_type' => NumberType::class,
                'allow_add' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercices::class,
        ]);
    }
}
