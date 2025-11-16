<?php

namespace App\ViewModel;

use App\Entity\Pet;
use App\Entity\PetType;
use App\Entity\Sex;

final readonly class PetViewModel
{
    public function __construct(
        public int $id,
        public string $name,
        public PetType $type,
        public array $breedNames,
        public Sex $sex,
        public ?float $age,
    ) {
    }

    public static function fromEntity(Pet $pet, ?\DateTimeImmutable $currentDate = null): self
    {
        return new self(
            id: $pet->getId(),
            name: $pet->getName(),
            type: $pet->getType(),
            breedNames: array_map(fn($breed) => $breed->getName(), $pet->getBreeds()->toArray()),
            sex: $pet->getSex(),
            age: $pet->getAge($currentDate),
        );
    }
}
