<?php

namespace Database\Factories\Guidance;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Guidance\GuidanceAccount;
use App\Models\Guidance\GuidanceNotification;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GuidanceNotification>
 */
class GuidanceNotificationFactory extends Factory
{
    protected $model = GuidanceNotification::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['message', 'alert', 'reminder']),
            'user_id' => GuidanceAccount::inRandomOrder()->first()->id ?? 1,
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
