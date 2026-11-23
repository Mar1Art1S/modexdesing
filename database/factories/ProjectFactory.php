<?php

namespace Database\Factories;

use App\Enums\ProjectCategory;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title_ua' => fake()->words(3, true),
            'title_en' => fake()->words(3, true),
            'category' => fake()->randomElement(ProjectCategory::cases()),
            'description_ua' => fake()->paragraph(),
            'description_en' => fake()->paragraph(),
            'image' => 'images/zas.jpg',
            'gallery' => [
                'images/house/008.jpg',
                'images/house/001.jpg',
            ],
            'order_column' => fake()->numberBetween(0, 10),
            'is_active' => true,
        ];
    }
}
