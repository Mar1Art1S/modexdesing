<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'service_type' => fake()->randomElement([
                '3D-Моделювання деталі з нуля',
                'Процес 3D-друку (готовий файл STL/STEP)',
                'Замовлення (Креслення / Фото деталі)',
                'Готова модель / Серійний тираж деталей',
            ]),
            'material' => fake()->randomElement(['PLA', 'PETG', 'ABS', 'TPU']),
            'quantity' => fake()->randomElement(['1', '5', '10', '50']),
            'details' => fake()->paragraph(),
            'files' => null,
            'status' => fake()->randomElement(OrderStatus::cases()),
            'estimated_price' => fake()->randomFloat(2, 20, 500),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
