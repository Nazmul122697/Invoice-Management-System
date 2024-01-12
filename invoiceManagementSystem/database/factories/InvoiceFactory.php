<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'invoice_number' => $this->faker->numberBetween(10, 10000),
            'customer_id' => $this->faker->numberBetween(1, 10),
            'date' => $this->faker->date(),
            'due_date' => $this->faker->date(),
            'reference' => 'REF-' . $this->faker->numberBetween(1000, 9999),
            'terms_and_condition' => $this->faker->text(),
            'sub_total' => $this->faker->numberBetween(100, 1000),
            'discount' => $this->faker->numberBetween(0, 100),
            'total'  => $this->faker->numberBetween(100, 1000),
        ];
    }
}
