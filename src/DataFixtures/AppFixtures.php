<?php

namespace App\DataFixtures;

use App\Entity\PetBreed;
use App\Entity\PetType;
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
        foreach (['Persian', 'Siamese'] as $breedName) {
            $petBreed = new PetBreed();
            $petBreed->setName($breedName);
            $petBreed->setType($this->getReference('Cat', PetType::class));
            $petBreed->setIsDangerous(false);
            $manager->persist($petBreed);
        }
        // Dog's breeds
        foreach (['Beagle', 'Labrador', 'Mastiff', 'Pitbull'] as $breedName) {
            $petBreed = new PetBreed();
            $petBreed->setName($breedName);
            $petBreed->setType($this->getReference('Dog', PetType::class));
            $petBreed->setIsDangerous(false);
            if ('Pitbull' === $breedName) {
                $petBreed->setIsDangerous(true);
            }
            $manager->persist($petBreed);
        }

        $manager->flush();
    }
}
