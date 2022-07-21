<?php

namespace App\Form;

use App\Entity\Qg;
use App\Entity\Target;
use App\Entity\Contact;
use App\Entity\Missions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MissionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description', TextareaType::class)
            ->add('country', CountryType::class)
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Surveillance' => 'Surveillance',
                    'Assassinat' => 'Assassinat',
                    'Infiltration' => 'Infiltration'
                ],
                'expanded' => false,
                'label' => 'Type',
                'required' => true
            ])
            ->add('code_name')
            ->add('start_date', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text'
            ])
            ->add('end_date', DateType::class, [
                // renders it as a single text box
                'widget' => 'single_text'
            ])
            ->add('speciality', ChoiceType::class, [
                'choices' => [
                    'Discrétion' => 'Discrétion',
                    'Assassin' => 'Assassin',
                    'Repérage' => 'Repérage'
                ],
                'expanded' => false,
                'label' => 'Speciality',
                'required' => true
            ])
            /*->add('contact', EntityType::class, [
                'class' => Contact::class,
                'choice_label' => 'lastname',
                'multiple' => true,
                'required' => true,
                'mapped' => true
            ])
            ->add('qg', EntityType::class, [
                'class' => Qg::class,
                'choice_label' => 'code',
                'multiple' => true,
                'required' => false,
                'mapped' => true
            ])*/
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'En préparation' => 'En préparation',
                    'En cours' => 'En cours',
                    'Terminée' => 'Terminée',
                    'Echec' => 'Echec',
                    'A faire' => 'A faire'
                ],
                'expanded' => false,
                'label' => 'Statut',
                'required' => true
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Missions::class,
            'translation_domain' => 'forms'
        ]);
    }
}
