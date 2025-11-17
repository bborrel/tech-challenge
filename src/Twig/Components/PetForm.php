<?php

namespace App\Twig\Components;

use App\Entity\Pet;
use App\Entity\PetBreed;
use App\Entity\PetType as PetTypeEntity;
use App\Form\PetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent]
final class PetForm extends AbstractController
{
    use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public ?Pet $initialFormData = null;

    // holds the selected type id; bound from the Type select via data-model
    #[LiveProp(writable: true)]
    public ?int $typeId = null;

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    protected function instantiateForm(): FormInterface
    {
        $pet = $this->initialFormData ?? new Pet();

        // If typeId not explicitly set, infer from the current Pet
        if (null === $this->typeId && $pet->getType() instanceof PetTypeEntity) {
            $this->typeId = $pet->getType()->getId();
        }

        $breedChoices = [];
        if ($this->typeId) {
            $breedChoices = $this->entityManager
                ->getRepository(PetBreed::class)
                ->findBy(['type' => $this->typeId]);
        }

        return $this->createForm(PetType::class, $pet, [
            'breed_choices' => $breedChoices,
        ]);
    }

    #[LiveAction]
    public function save(EntityManagerInterface $entityManager): Response
    {
        $this->submitForm();

        /** @var Pet $pet */
        $pet = $this->getForm()->getData();
        
        $entityManager->persist($pet);
        $entityManager->flush();

        $this->addFlash('success', sprintf('Pet "%s" has been saved!', $pet->getName()));

        return $this->redirectToRoute('app_pet_index');
    }
}
