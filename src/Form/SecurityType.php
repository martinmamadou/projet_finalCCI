<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class SecurityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nom d\'utilisateur :',
                'required' => 'false',
                'attr' => [
                    'placeholder' => 'johndoe'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => 'false',
                'attr' => [
                    'placeholder' => 'johndoe@gmail.com'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => 'false',
                'first_options'  => ['label' => 'Mot de Passe :', 'attr' => [
                    'placeholder' => 'S3CR3T'
                ]],
                'second_options' => ['label' => 'Confirmation Mot de passe : ',  'attr' => [
                    'placeholder' => 'S3CR3T'
                ]],
                'attr' => [
                    'placeholder' => 'S3CR3T'
                ]
                ]);





        if ($options['isAdmin']) {
            $builder
                ->remove('password')
                ->add('roles', ChoiceType::class, [
                    'label' => 'Roles :',
                    'placeholder' => 'Sélectionner un role',
                    'choices' => [
                        'Utilisateur' => 'ROLE_USER',
                        'Administrateur' => 'ROLE_ADMIN',
                    ],
                    'expanded' => true,
                    'multiple' => true,
                ]);
        }


        if($options['isUser']){
            $builder
            ->add('imageFile', FileType::class, [
                'label' => 'Photo de profil',
                'required' => false
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'isAdmin' => false,
            'isUser' => true,
            'sanitize_html' => true,
        ]);
    }
}
