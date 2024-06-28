<?php
namespace Modules\Transactions\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Transactions\Models\Transaction;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name()
        ];
    }
}