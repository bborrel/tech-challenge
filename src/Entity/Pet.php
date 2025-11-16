<?php

namespace App\Entity;

use App\Enum\Sex;
use App\Repository\PetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, PetBreed>
     */
    #[ORM\ManyToMany(targetEntity: PetBreed::class, inversedBy: 'pets')]
    private Collection $breeds;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $date_of_birth = null;

    #[ORM\Column(nullable: true)]
    private ?float $approximate_age = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $date_of_age_approximation = null;

    #[ORM\Column(enumType: Sex::class)]
    private ?Sex $sex = null;

    public function __construct()
    {
        $this->breeds = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, PetBreed>
     */
    public function getBreeds(): Collection
    {
        return $this->breeds;
    }

    public function addBreed(PetBreed $breed): static
    {
        if (!$this->breeds->contains($breed)) {
            $this->breeds->add($breed);
        }

        return $this;
    }

    public function removeBreed(PetBreed $breed): static
    {
        $this->breeds->removeElement($breed);

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

    public function getDateOfBirth(): ?\DateTimeImmutable
    {
        return $this->date_of_birth;
    }

    public function setDateOfBirth(?\DateTimeImmutable $date_of_birth): static
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

    public function getDateOfAgeApproximation(): ?\DateTimeImmutable
    {
        return $this->date_of_age_approximation;
    }

    public function setDateOfAgeApproximation(?\DateTimeImmutable $date_of_age_approximation): static
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

    /**
     * Return pet's age depending on available data:
     * - date_of_birth if known,
     * - otherwise from actualised approximate_age.
     * - otherwise null
     */
    public function getAge(?\DateTimeImmutable $currentDate): ?float
    {
        if (null === $currentDate) {
            $currentDate = new \DateTimeImmutable();
        }

        if (null !== $this->date_of_birth) {
            $ageInterval = $currentDate->diff($this->date_of_birth);

            return $ageInterval->y + ($ageInterval->m / 12) + ($ageInterval->d / 365);
        }

        if (null !== $this->approximate_age && null !== $this->date_of_age_approximation) {
            $ageInterval = $currentDate->diff($this->date_of_age_approximation);

            return $this->approximate_age + $ageInterval->y + ($ageInterval->m / 12) + ($ageInterval->d / 365);
        }

        return null;
    }
}
