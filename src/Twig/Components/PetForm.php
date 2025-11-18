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

    #[LiveProp]
    public ?Pet $initialFormData = null;

    #[LiveProp(writable: true, onUpdated: 'onTypeUpdated')]
    public ?int $typeId = null;

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    protected function instantiateForm(): FormInterface
    {
        $pet = $this->initialFormData ?? new Pet();

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

    public function onTypeUpdated(): void
    {
        if (null === $this->typeId) {
            return;
        }

        $this->formValues['type'] = $this->typeId;
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

        return $this->redirectToRoute('app_pet_show', ['id' => $pet->getId()]);
    }
}
