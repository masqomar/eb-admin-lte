<?php
namespace Modules\Coupons\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Coupons\Models\Coupon;

class CouponFactory extends Factory
{
    protected $model = Coupon::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name()
        ];
    }
}