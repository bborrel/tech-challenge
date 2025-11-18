<?php

namespace App\Controller;

use App\Entity\Pet;
use App\Form\PetType;
use App\Repository\PetRepository;
use App\ViewModel\PetViewModel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class PetController extends AbstractController
{
    #[Route(name: 'app_pet_index', methods: ['GET'])]
    public function index(PetRepository $petRepository): Response
    {
        $pets = array_map(
            fn (Pet $pet) => PetViewModel::fromEntity($pet),
            $petRepository->findAll()
        );

        return $this->render('pet/index.html.twig', [
            'pets' => $pets,
        ]);
    }

    #[Route('/new', name: 'app_pet_new', methods: ['GET'])]
    public function new(): Response
    {
        return $this->render('pet/new.html.twig', [
            'pet' => null,
        ]);
    }

    #[Route('/{id}', name: 'app_pet_show', methods: ['GET'])]
    public function show(Pet $pet): Response
    {
        return $this->render('pet/show.html.twig', [
            'pet' => PetViewModel::fromEntity($pet),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pet_edit', methods: ['GET'])]
    public function edit(Pet $pet): Response
    {
        return $this->render('pet/edit.html.twig', [
            'pet' => $pet,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_pet_delete', methods: ['POST'])]
    public function delete(Request $request, Pet $pet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pet->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($pet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pet_index', [], Response::HTTP_SEE_OTHER);
    }
}
