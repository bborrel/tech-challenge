<?php

namespace App\Form;

use App\Entity\Pet;
use App\Entity\PetBreed;
use App\Entity\PetType as PetTypeEntity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('date_of_birth', null, [
                'widget' => 'single_text',
            ])
            ->add('approximate_age')
            ->add('date_of_age_approximation', null, [
                'widget' => 'single_text',
            ])
            ->add('sex')
            ->add('type', EntityType::class, [
                'class' => PetTypeEntity::class,
                'choice_label' => 'id',
            ])
            ->add('breed', EntityType::class, [
                'class' => PetBreed::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pet::class,
        ]);
    }
}
