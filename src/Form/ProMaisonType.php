<?php

namespace App\Form;

use App\Entity\ExerciceMaison;
use App\Entity\ProgrammeMaison;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProMaisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'nom programme',
                'required' => false,
                'attr' => [
                    'placeholder' => 'push-prog'
                ]

            ])
            ->add('shortDescription', TextType::class, [
                'label' => 'Courte Description',
                'required' => false,
                'attr' => [
                    'placeholder' => 'super description'
                ]
                ])
            ->add('enable')
            ->add('exerciceMaisons', CollectionType::class, [
                'required' => false,
                'label' => false,
                'entry_type' => ExMaisonType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProgrammeMaison::class,
        ]);
    }
}
