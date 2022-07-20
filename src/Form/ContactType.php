<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\Missions;
use App\Repository\MissionsRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $nationality = $options['data']->getNationality();

        //dump($nationality);

        $builder
            ->add('lastname')
            ->add('firstname')
            ->add('birth')
            ->add('name_code')
            ->add('nationality', CountryType::class)
            ->add('missions', EntityType::class, [
                'class' => Missions::class,
                'choice_label' => 'title',
                'multiple' => false,
                'required' => true,
                'query_builder' => function (MissionsRepository $mr) use ($nationality){
                    return $mr->createQueryBuilder('m')
                    ->andWhere('m.country = :val')
                    ->setParameter('val', $nationality)
                    ->orderBy('m.id', 'ASC')
                ;
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
