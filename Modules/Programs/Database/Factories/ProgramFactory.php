<?php
namespace Modules\Programs\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Programs\Models\Program;

class ProgramFactory extends Factory
{
    protected $model = Program::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name()
        ];
    }
}