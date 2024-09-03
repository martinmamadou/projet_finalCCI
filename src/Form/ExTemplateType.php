<?php

namespace App\Form;

use App\Entity\Exercices;
use App\Entity\ExTemplate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use phpDocumentor\Reflection\DocBlock\Description;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

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
            
            ->add('imageFile', FileType::class, [
                'label' => 'Photo Type : ',
                'required' => false
            ]);
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
