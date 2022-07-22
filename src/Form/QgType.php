<?php

namespace App\Form;

use App\Entity\Qg;
use App\Entity\Missions;
use App\Repository\MissionsRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class QgType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $country = $options['data']->getCountry();
        $builder
            ->add('code')
            ->add('address')
            ->add('country', CountryType::class)
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Appartement' => 'Appartement',
                    'Maison' => 'Maison',
                    'Bunker' => 'Bunker'
                ],
                'expanded' => false,
                'label' => 'Type',
                'required' => true
            ])
            ->add('missions', EntityType::class, [
                'class' => Missions::class,
                'choice_label' => 'title',
                'multiple' => false,
                'required' => false,
                'query_builder' => function (MissionsRepository $mr) use ($country){
                    return $mr->createQueryBuilder('m')
                    ->andWhere('m.country = :val')
                    ->setParameter('val', $country)
                    ->orderBy('m.id', 'ASC')
                ;
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Qg::class,
            'translation_domain' => 'forms'
        ]);
    }
}
