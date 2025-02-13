<?php

namespace Database\Factories\Teacher;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher\TeacherAccount;
use App\Models\Teacher\TeacherNotification;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TeacherNotification>
 */
class TeacherNotificationFactory extends Factory
{
    protected $model = TeacherNotification::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['message', 'alert', 'reminder']),
            'user_id' => TeacherAccount::inRandomOrder()->first()->id ?? 1,
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
