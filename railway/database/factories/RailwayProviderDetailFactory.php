<?php

namespace Database\Factories;

use App\Models\RailwayProviderDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RailwayProviderDetail>
 */
class RailwayProviderDetailFactory extends Factory
{
    protected $model = RailwayProviderDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'provider'
        ];
    }
}
