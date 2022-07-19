<?php

namespace App\Form;

use App\Entity\Target;
use App\Entity\Missions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MissionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('country')
            ->add('type')
            ->add('code_name')
            ->add('start_date')
            ->add('end_date')
            ->add('speciality')
            ->add('targets', EntityType::class, [
                'class' => Target::class,
                'choice_label' => 'lastname',
                'multiple' => true,
                'required' => false
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'En préparation' => 'En préparation',
                    'En cours' => 'En cours',
                    'Terminée' => 'Terminée',
                    'Echec' => 'Echec',
                    'A faire' => 'A faire'
                ],
                'expanded' => true,
                'label' => 'Statut',
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Missions::class,
        ]);
    }
}
