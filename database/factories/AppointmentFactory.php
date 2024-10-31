<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\HealthCenter;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::where('role', 'patient')->inRandomOrder()->first()->id,
            'doctor_id' => Doctor::inRandomOrder()->first()->id,
            'health_center_id' => HealthCenter::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['approved', 'cancelled', 'adjusted']),
            'date' => $this->faker->date(),
            'time' => $this->faker->time(),
            'remarks' => $this->faker->text(),
        ];
    }
}
