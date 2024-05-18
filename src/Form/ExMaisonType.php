<?php

namespace App\Form;

use App\Entity\Exercices;
use App\Entity\DetailExercice;
use App\Entity\ExerciceMaison;
use App\Entity\ProgrammeMaison;
use Doctrine\ORM\Mapping\Entity;
use App\Repository\ExercicesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ExMaisonType extends AbstractType
{
    private $exercicesRepository;

    public function __construct(ExercicesRepository $exercicesRepository)
    {
        $this->exercicesRepository = $exercicesRepository;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['isUser']) {
            
    
    
    
            $builder
                ->add('name', EntityType::class, [
                    'label' => 'Exercice',
                    'class'=> Exercices::class,
                    'choices' => $this->exercicesRepository->findDistinctFirstOccurrences(),
                    'choice_label' => 'name'
                ])
                ->add('repetitions', NumberType::class, [
                    'label' => 'Répétitions',
                ])
                ->add('temps', NumberType::class, [
                    'label' => 'Temps (en secondes)',
                ])
                ->add('serie', NumberType::class, [
                    'label' => 'Séries',
                ]);
        } else {
            $builder->add('name', TextType::class, [
                'label' => 'Nom de l\'exercice',
            ]);
        }
    }
      

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercices::class,
            'isUser' => true
        ]);
    }
}
