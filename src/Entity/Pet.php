<?php

namespace App\Entity;

use App\Repository\PetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: PetRepository::class)]
#[Broadcast]
class Pet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'pets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PetType $type = null;

    #[ORM\ManyToOne(inversedBy: 'pets')]
    private ?PetBreed $breed = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $date_of_birth = null;

    #[ORM\Column(nullable: true)]
    private ?float $approximate_age = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $date_of_age_approximation = null;

    #[ORM\Column(enumType: Sex::class)]
    private ?Sex $sex = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?PetType
    {
        return $this->type;
    }

    public function setType(?PetType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getBreed(): ?PetBreed
    {
        return $this->breed;
    }

    public function setBreed(?PetBreed $breed): static
    {
        $this->breed = $breed;

        return $this;
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

    public function getDateOfBirth(): ?\DateTime
    {
        return $this->date_of_birth;
    }

    public function setDateOfBirth(?\DateTime $date_of_birth): static
    {
        $this->date_of_birth = $date_of_birth;

        return $this;
    }

    public function getApproximateAge(): ?float
    {
        return $this->approximate_age;
    }

    public function setApproximateAge(?float $approximate_age): static
    {
        $this->approximate_age = $approximate_age;

        return $this;
    }

    public function getDateOfAgeApproximation(): ?\DateTime
    {
        return $this->date_of_age_approximation;
    }

    public function setDateOfAgeApproximation(?\DateTime $date_of_age_approximation): static
    {
        $this->date_of_age_approximation = $date_of_age_approximation;

        return $this;
    }

    public function getSex(): ?Sex
    {
        return $this->sex;
    }

    public function setSex(Sex $sex): static
    {
        $this->sex = $sex;

        return $this;
    }
}
