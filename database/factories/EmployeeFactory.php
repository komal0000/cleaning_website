<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'employee_code' => str_pad((string) fake()->unique()->numberBetween(0, 9999), 4, '0', STR_PAD_LEFT),
            'employee_password' => Hash::make('123456'),
            'email' => fake()->safeEmail(),
            'is_active' => true,
        ];
    }
}
