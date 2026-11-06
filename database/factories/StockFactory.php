<?php

namespace Database\Factories;

use App\Features\Stock\Enums\StockStatus;
use App\Features\Stock\Models\Stock;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Stock>
 */
class StockFactory extends Factory
{
    protected $model = Stock::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = fake()->numberBetween(0, 200);
        $minStock = fake()->numberBetween(1, 20);

        return [
            'user_id' => User::factory(),
            'name' => fake()->words(3, true),
            'sku' => strtoupper(fake()->unique()->bothify('SKU-????-####')),
            'description' => fake()->sentence(),
            'quantity' => $quantity,
            'unit' => fake()->randomElement(['pcs', 'box', 'kg', 'liter', 'pack']),
            'price' => fake()->randomFloat(2, 1000, 5000000),
            'min_stock' => $minStock,
            'status' => StockStatus::fromQuantity($quantity, $minStock)->value,
        ];
    }

    /**
     * Indicate that the stock is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => 100,
            'min_stock' => 5,
            'status' => StockStatus::Available->value,
        ]);
    }

    /**
     * Indicate that the stock is low.
     */
    public function lowStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => 3,
            'min_stock' => 5,
            'status' => StockStatus::LowStock->value,
        ]);
    }

    /**
     * Indicate that the stock is out of stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'quantity' => 0,
            'min_stock' => 5,
            'status' => StockStatus::OutOfStock->value,
        ]);
    }
}
