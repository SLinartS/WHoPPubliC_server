<?php

namespace Database\Factories;

use App\Models\WorkSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkSchedule>
 */
class WorkScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = WorkSchedule::class;

    public function definition()
    {
        return [
            'start_time' => '08:00:00',
            'end_time' => '20:00:00',
            'day_of_week' => 0,
            'user_id' => 1
        ];
    }
}
