<?php

namespace Database\Factories;

use App\Module\User\Model\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'phone' => $this->faker->randomNumber(),
            'verify_code' => $this->faker->unique()->randomNumber(),
            'is_verified' => $this->faker->boolean(),
            'is_stop' => $this->faker->boolean(),
            'is_business' => $this->faker->boolean(),
            'language' => $this->faker->languageCode(),
        ];
    }
}
