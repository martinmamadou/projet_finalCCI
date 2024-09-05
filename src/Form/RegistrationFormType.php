<?php

namespace App\Form;

use Assert\Length;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Webmozart\Assert\Assert as AssertAssert;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'email',
                'attr'=> ['placeholder'=>'johndoe@gmail.com']
            ])
            ->add('username', TextType::class, [
                'label' => "Pseudo",
                'attr' => ['placeholder'=>'johndoe'],
                'required' => false
            ])
            ->add('password', RepeatedType::class, [
                'required' => true, // rend le champ obligatoire
                'type' => PasswordType::class,
                'first_options' =>  ['label' => "Mot de passe ",'attr'=>['placeholder'=>'S3CR3T'], 'constraints' => [
                        new Assert\NotBlank(
                            [],
                            message: 'veuillez renseigner un mot de passe'
                        ),
                        new Assert\Length([
                            'max' => 4096
                        ]),
                        new Assert\Regex(
                            pattern: '/^(?=.\d)(?=.[A-Z])(?=.[a-z])(?=.[^\w\d\s:])([^\s]){8,16}$/',
                            message: 'le mot de passe doit contenir au minimum 1 lettre majuscule, minuscule, 1 chiffre et un caractère spécial'
                        )
                    ]
                        ], // premier champ
                'second_options' => ['label'=>'Confirmation mot de passe ','attr' => ['placeholder' => 'S3CR3T']], // deuxième champ
                'invalid_message' => 'Les mots de passe doivent correspondre.', // message d'erreur
                'constraints' => [ // ajoute des contraintes de validation pour ce champ
                    new NotBlank(['message' => 'Veuillez entrer un mot de passe.']),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label'=> 'accepter les conditions',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ]);
           
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
