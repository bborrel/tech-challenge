<?php

namespace App\Entity;

use App\Repository\PetTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: PetTypeRepository::class)]
#[Broadcast]
class PetType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, PetBreed>
     */
    #[ORM\OneToMany(targetEntity: PetBreed::class, mappedBy: 'type')]
    private Collection $petBreeds;

    /**
     * @var Collection<int, Pet>
     */
    #[ORM\OneToMany(targetEntity: Pet::class, mappedBy: 'type')]
    private Collection $pets;

    public function __construct()
    {
        $this->petBreeds = new ArrayCollection();
        $this->pets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, PetBreed>
     */
    public function getPetBreeds(): Collection
    {
        return $this->petBreeds;
    }

    public function addPetBreed(PetBreed $petBreed): static
    {
        if (!$this->petBreeds->contains($petBreed)) {
            $this->petBreeds->add($petBreed);
            $petBreed->setType($this);
        }

        return $this;
    }

    public function removePetBreed(PetBreed $petBreed): static
    {
        if ($this->petBreeds->removeElement($petBreed)) {
            // set the owning side to null (unless already changed)
            if ($petBreed->getType() === $this) {
                $petBreed->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Pet>
     */
    public function getPets(): Collection
    {
        return $this->pets;
    }

    public function addPet(Pet $pet): static
    {
        if (!$this->pets->contains($pet)) {
            $this->pets->add($pet);
            $pet->setType($this);
        }

        return $this;
    }

    public function removePet(Pet $pet): static
    {
        if ($this->pets->removeElement($pet)) {
            // set the owning side to null (unless already changed)
            if ($pet->getType() === $this) {
                $pet->setType(null);
            }
        }

        return $this;
    }
}
