<?php
namespace Modules\ProgramTypes\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ProgramTypes\Models\ProgramType;

class ProgramTypeFactory extends Factory
{
    protected $model = ProgramType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name()
        ];
    }
}