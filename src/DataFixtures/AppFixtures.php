<?php

namespace App\DataFixtures;

use App\Entity\Pet;
use App\Entity\PetBreed;
use App\Entity\PetType;
use App\Enum\Sex;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Pet types
        foreach (['Cat', 'Dog'] as $typeName) {
            $petType = new PetType();
            $petType->setName($typeName);
            $manager->persist($petType);
            $this->addReference($typeName, $petType);
        }

        // Cat's breeds
        foreach (['Unknown', 'Siamese', 'Tabby'] as $breedName) {
            $petBreed = new PetBreed();
            $petBreed->setName($breedName);
            $petBreed->setType($this->getReference('Cat', PetType::class));
            $petBreed->setIsDangerous(false);
            $manager->persist($petBreed);
            $this->addReference($breedName, $petBreed);
        }

        // Dog's breeds
        foreach (['Unknown', 'Beagle', 'Labrador', 'Mastiff', 'Pitbull'] as $breedName) {
            $petBreed = new PetBreed();
            $petBreed->setName($breedName);
            $petBreed->setType($this->getReference('Dog', PetType::class));
            $petBreed->setIsDangerous(false);
            if ('Pitbull' === $breedName) {
                $petBreed->setIsDangerous(true);
            }
            $manager->persist($petBreed);
            $this->setReference($breedName, $petBreed);
        }

        // Demo data
        $pets = [
            'Minka' => [
                'setType' => $this->getReference('Cat', PetType::class),
                'addBreed' => $this->getReference('Tabby', PetBreed::class),
                'setName' => 'Minka',
                'setApproximateAge' => 3.5,
                'setSex' => Sex::Female,
            ],
            'Taupi' => [
                'setType' => $this->getReference('Cat', PetType::class),
                'addBreed' => $this->getReference('Unknown', PetBreed::class),
                'setName' => 'Taupi',
                'setDateOfBirth' => new \DateTimeImmutable('2024-04-02'),
                'setSex' => Sex::Female,
            ],
            'Doggy' => [
                'setType' => $this->getReference('Dog', PetType::class),
                'addBreed' => [
                    $this->getReference('Unknown', PetBreed::class),
                    $this->getReference('Pitbull', PetBreed::class),
                ],
                'setName' => 'Doggy',
                'setSex' => Sex::Male,
            ],
        ];
        foreach ($pets as $petData) {
            $pet = new Pet();
            foreach ($petData as $method => $value) {
                if (is_array($value)) {
                    foreach ($value as $v) {
                        $pet->{$method}($v);
                    }
                } else {
                    $pet->{$method}($value);
                }
            }
            $manager->persist($pet);
        }

        $manager->flush();
    }
}
