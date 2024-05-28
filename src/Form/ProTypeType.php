<?php

namespace App\Form;

use App\Entity\ProType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom : ',
                'required' => false,
                'attr' => [
                    'label' => 'Mon super nom'
                ]
            ])

            ->add('imageFile', FileType::class, [
                'label' => 'Photo Type : ',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProType::class,
        ]);
    }
}
