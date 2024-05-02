<?php

namespace App\Form;

use App\Entity\DetailExercice;
use App\Entity\Exercices;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('repetition', NumberType::class, [
                'label' => 'repetition :',
                'required' => 'false',
            ])
            ->add('temps', NumberType::class, [
                'label' => 'repetition :',
                'required' => 'false',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DetailExercice::class,
        ]);
    }
}
