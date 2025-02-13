<?php

namespace Database\Factories\Student;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student\StudentAccount;
use App\Models\Student\StudentNotification;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentNotification>
 */
class StudentNotificationFactory extends Factory
{
    protected $model = StudentNotification::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['message', 'alert', 'reminder']),
            'user_id' => StudentAccount::inRandomOrder()->first()->id ?? 1,
            'title' => $this->faker->sentence(5),
            'message' => $this->faker->paragraph(),
            'url' => $this->faker->optional()->url(),
            'icon' => $this->faker->randomElement(['bell', 'envelope', 'info-circle']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
