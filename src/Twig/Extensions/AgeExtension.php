<?php

namespace App\Twig\Extensions;

use Twig\Attribute\AsTwigFilter;

final class AgeExtension
{
    /**
     * Format a decimal age in years into a human readable string.
     * Examples:
     *  - 2.5 => "2 years 6 months"
     *  - 1.0 => "1 year"
     *  - 0.5 => "6 months"
     * If $short is true the compact form is returned (e.g. "2y 6m").
     */
    #[AsTwigFilter('format_age')]
    public function formatAge(?float $age, bool $short = false): string
    {
        if (null === $age) {
            return 'Unknown';
        }

        $years = (int) floor($age);
        $months = (int) floor(($age - $years) * 12);

        if (12 === $months) {
            ++$years;
            $months = 0;
        }

        if ($short) {
            $out = $years.'y';
            if ($months > 0) {
                $out .= ' '.$months.'m';
            }

            return $out;
        }

        // Long, English form with simple pluralization (no localization)
        $parts = [];
        if ($years > 0) {
            $parts[] = $years.' '.(1 === $years ? 'year' : 'years');
        }

        if ($months > 0) {
            $parts[] = $months.' '.(1 === $months ? 'month' : 'months');
        }

        if (empty($parts)) {
            return '0 years';
        }

        return implode(' ', $parts);
    }
}
