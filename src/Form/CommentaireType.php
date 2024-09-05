<?php

namespace App\Form;

use App\Entity\Commentaires;
use App\Entity\Programme;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre : ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Mon super commentaire'

                ]
            ])
            ->add('note', RangeType::class, [
                'label' => 'note',

                'attr' => [
                    'min' => 1,
                    'max' => 5
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message : ',
                'required' => false,
                'attr' => [
                    'placeholder' => 'J\'aime trop'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaires::class,
        ]);
    }
}
