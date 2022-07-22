<?php

namespace App\Form;

use App\Entity\Target;
use App\Entity\Missions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

class TargetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('birth', BirthdayType::class, [
                // renders it as a single text box
                'widget' => 'single_text'
            ])
            ->add('name_code')
            ->add('nationality', CountryType::class)
            ->add('mission', EntityType::class, [
                'class' => Missions::class,
                'choice_label' => 'title',
                'multiple' => false,
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Target::class,
            'translation_domain' => 'forms'
        ]);
    }
}
