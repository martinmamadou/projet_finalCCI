<?php

namespace App\Form;

use App\Entity\Exercices;
use App\Entity\ExTemplate;
use App\Entity\Membre;
use phpDocumentor\Reflection\DocBlock\Description;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExTemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
            'label' => 'Nom de l\'exercice',
            'required' => false,

            ])
            ->add('instruction', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'row' => 10
                ],
                'required' => false
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExTemplate::class,
            'isUser' => true
        ]);
    }
}
