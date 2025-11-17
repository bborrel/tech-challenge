<?php

namespace App\Form;

use App\Entity\Pet;
use App\Entity\PetBreed;
use App\Entity\PetType as PetTypeEntity;
use App\Enum\Sex;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class PetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $builder = new DynamicFormBuilder($builder);

        $builder

            ->add('name', TextType::class, [
                'label' => "What is your pet's name?",
                'attr' => ['placeholder' => 'Enter pet name'],
                'required' => true,
            ])

            // @todo add Modal so that user is able to create new PetType on the fly
            ->add('type', EntityType::class, [
                'class' => PetTypeEntity::class,
                'choice_label' => 'name',
                'label' => 'What type of pet is it?',
                'placeholder' => 'Select a type',
                'required' => true,
            ])

            // @todo add autocomplete
            // @todo add Modal so that user is able to create new PetBreed on the fly
            // @todo selected item as pills/tags
            ->add('breeds', EntityType::class, [
                'class' => PetBreed::class,
                'choice_label' => 'name',
                'label' => 'What breed(s) is it?',
                'multiple' => true,
                'expanded' => false,
                'required' => true,
                'choices' => $options['breed_choices'],
                'placeholder' => 'Select breed(s)',
            ])

            // ->add('date_of_birth', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('approximate_age')
            // ->add('date_of_age_approximation', null, [
            //     'widget' => 'single_text',
            // ])

            ->add('sex', EnumType::class, [
                'class' => Sex::class,
                'label' => 'What gender is it?',
                'expanded' => true,
                'multiple' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pet::class,
            'breed_choices' => [],
        ]);

        $resolver->setAllowedTypes('breed_choices', ['array']);
    }
}
