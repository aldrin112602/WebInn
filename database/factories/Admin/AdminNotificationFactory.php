<?php

namespace Database\Factories\Admin;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Admin\AdminNotification;
use App\Models\Admin\AdminAccount;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\AdminNotification>
 */
class AdminNotificationFactory extends Factory
{
    protected $model = AdminNotification::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['message', 'alert', 'reminder']),
            'user_id' => AdminAccount::inRandomOrder()->first()->id ?? 1,
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
