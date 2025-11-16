<?php

namespace App\ViewModel;

use App\Entity\Pet;
use App\Entity\PetBreed;
use App\Entity\PetType;
use App\Entity\Sex;

final readonly class PetViewModel
{
    public function __construct(
        public int $id,
        public string $name,
        public PetType $type,
        public ?PetBreed $breed,
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
            breed: $pet->getBreed(),
            sex: $pet->getSex(),
            age: $pet->getAge($currentDate),
        );
    }
}
