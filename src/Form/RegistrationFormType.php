<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'johnDoe@Test.com'
            ])
            ->add('username', TextType::class, [
                'label' => "JohnDoe",
                'required' => false
            ])
            ->add('password', RepeatedType::class, [
                'required' => true, // rend le champ obligatoire
                'type' => PasswordType::class,
                'first_options' => ['attr' => ['placeholder' => 'Entrez votre mot de passe']], // premier champ
                'second_options' => ['attr' => ['placeholder' => 'Veuillez confirmer votre mot de passe']], // deuxième champ
                'invalid_message' => 'Les mots de passe doivent correspondre.', // message d'erreur
                'constraints' => [ // ajoute des contraintes de validation pour ce champ
                    new NotBlank(['message' => 'Veuillez entrer un mot de passe.']),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
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
