<?php

namespace Database\Factories;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Grade>
 */
class GradeFactory extends Factory
{
    public function definition(): array
    {
        $data = [
            'observations' => fake()->optional()->sentence(),
        ];

        foreach (['t1', 't2', 't3'] as $t) {
            for ($i = 1; $i <= 6; $i++) {
                $data["{$t}_ind_{$i}"] = fake()->optional(0.3)->randomFloat(2, 0, 10);
            }
            for ($i = 1; $i <= 6; $i++) {
                $data["{$t}_grp_{$i}"] = fake()->optional(0.3)->randomFloat(2, 0, 10);
            }
            for ($i = 1; $i <= 2; $i++) {
                $data["{$t}_ref_{$i}"] = fake()->optional(0.2)->randomFloat(2, 0, 10);
            }
            $data["{$t}_proj"] = fake()->optional(0.2)->randomFloat(2, 0, 10);
            $data["{$t}_eval"] = fake()->optional(0.2)->randomFloat(2, 0, 10);
        }

        return $data;
    }
}
