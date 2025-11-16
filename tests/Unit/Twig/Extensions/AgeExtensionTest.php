<?php

namespace App\Tests\Unit;

use App\Twig\Extensions\AgeExtension;
use PHPUnit\Framework\TestCase;

class AgeExtensionTest extends TestCase
{
    public function testFormatsVariousValues(): void
    {
        $ext = new AgeExtension();

        $this->assertSame('Unknown', $ext->formatAge(null));
        $this->assertSame('0 years', $ext->formatAge(0.0));
        $this->assertSame('1 year', $ext->formatAge(1.0));
        $this->assertSame('6 months', $ext->formatAge(0.5));
        $this->assertSame('2 years 6 months', $ext->formatAge(2.5));

        // short form
        $this->assertSame('2y 6m', $ext->formatAge(2.5, true));
        $this->assertSame('2y', $ext->formatAge(2.0, true));
    }
}
