<?php

namespace App\Services;

class QualitativeGradingService
{
    /**
     * Map of detailed scale to numerical values.
     */
    const SCALE_VALUES = [
        'A+' => 10,
        'A' => 9, // Using A as 9
        'A-' => 9,
        'B+' => 8,
        'B' => 7, // Using B as 7
        'B-' => 7,
        'C+' => 6,
        'C' => 5, // Using C as 5
        'C-' => 5,
        'D+' => 4,
        'D' => 3, // Using D as 3
        'D-' => 3,
        'E+' => 2,
        'E' => 1, // Using E as 1
        'E-' => 1,
    ];

    /**
     * Check if a grade is valid.
     */
    public function isValidGrade(?string $grade): bool
    {
        if (empty($grade) || $grade === 'NE') {
            return true;
        }

        return array_key_exists(strtoupper($grade), self::SCALE_VALUES);
    }

    /**
     * Convert a qualitative grade to its numerical value.
     */
    public function getNumericalValue(?string $grade): ?int
    {
        if (empty($grade) || $grade === 'NE') {
            return null;
        }

        $grade = strtoupper($grade);

        return self::SCALE_VALUES[$grade] ?? null;
    }

    /**
     * Calculate the final grade for a domain based on the items' grades.
     * Replicates the Excel logic: IFERROR(INT(FIXED(TRUNC(AVERAGE(...),2),0)),"")
     *
     * @param  array  $grades  List of qualitative grades (e.g. ['A+', 'B-', 'NE', 'A'])
     * @return string Final translated scale ('A', 'EP', 'I', 'NE')
     */
    public function calculateDomainGrade(array $grades): string
    {
        $numericalGrades = [];

        foreach ($grades as $grade) {
            $val = $this->getNumericalValue($grade);
            if ($val !== null) {
                $numericalGrades[] = $val;
            }
        }

        if (empty($numericalGrades)) {
            return 'NE';
        }

        // Calculate average
        $average = array_sum($numericalGrades) / count($numericalGrades);

        // Truncate to 2 decimals
        $truncated = floor($average * 100) / 100;

        // Round to nearest integer (similar to FIXED(..., 0) or INT in Excel)
        $rounded = (int) round($truncated);

        return $this->translateToFinalScale($rounded);
    }

    /**
     * Translate numerical average to the final qualitative scale (A, EP, I, NE).
     */
    public function translateToFinalScale(int $score): string
    {
        if ($score >= 8 && $score <= 10) {
            return 'A'; // Alcanzada
        } elseif ($score >= 5 && $score < 8) {
            return 'EP'; // En Proceso
        } elseif ($score >= 1 && $score < 5) {
            return 'I'; // Iniciada
        }

        return 'NE'; // No Evaluada
    }
}
