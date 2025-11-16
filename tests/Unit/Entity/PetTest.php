<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Pet;
use PHPUnit\Framework\TestCase;

class PetTest extends TestCase
{
    public function testGetAgeWhenDateOfBirth(): void
    {
        // Arrange
        $pet = new Pet();
        $pet->setDateOfBirth(new \DateTimeImmutable('2020-01-01'));
        $pet->setApproximateAge(null);
        $pet->setDateOfAgeApproximation(null);
        $currentDate = new \DateTimeImmutable('2025-11-15');

        // Act
        $age = $pet->getAge($currentDate);

        // Assert
        $this->assertEquals(5.9, round($age, 1));
    }

    public function testGetAgeWhenAgeApproximatedSameDate(): void
    {
        // Arrange
        $pet = new Pet();
        $pet->setDateOfBirth(null);
        $pet->setApproximateAge(3.5);
        $pet->setDateOfAgeApproximation(new \DateTimeImmutable('2025-11-15'));
        $currentDate = new \DateTimeImmutable('2025-11-15');

        // Act
        $age = $pet->getAge($currentDate);

        // Assert
        $this->assertEquals(3.5, round($age, 1));
    }

    public function testGetAgeWhenAgeApproximatedEarlierDate(): void
    {
        // Arrange
        $pet = new Pet();
        $pet->setDateOfBirth(null);
        $pet->setApproximateAge(2.0);
        $pet->setDateOfAgeApproximation(new \DateTimeImmutable('2024-11-15'));
        $currentDate = new \DateTimeImmutable('2025-11-15');

        // Act
        $age = $pet->getAge($currentDate);

        // Assert
        $this->assertEquals(3.0, round($age, 1));
    }

    public function testGetAgeWhenNoAgeData(): void
    {
        // Arrange
        $pet = new Pet();
        $pet->setDateOfBirth(null);
        $pet->setApproximateAge(null);
        $pet->setDateOfAgeApproximation(null);
        $currentDate = new \DateTimeImmutable('2025-11-15');

        // Act
        $age = $pet->getAge($currentDate);

        // Assert
        $this->assertNull($age);
    }
}
