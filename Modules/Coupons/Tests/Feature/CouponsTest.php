<?php

use Modules\Coupons\Models\Coupon;

uses(Tests\TestCase::class);

test('can see coupon list', function() {
    $this->authenticate();
   $this->get(route('app.coupons.index'))->assertOk();
});

test('can see coupon create page', function() {
    $this->authenticate();
   $this->get(route('app.coupons.create'))->assertOk();
});

test('can create coupon', function() {
    $this->authenticate();
   $this->post(route('app.coupons.store', [
       'name' => 'Joe',
       'email' => 'joe@joe.com'
   ]))->assertRedirect(route('app.coupons.index'));

   $this->assertDatabaseCount('coupons', 1);
});

test('can see coupon edit page', function() {
    $this->authenticate();
    $coupon = Coupon::factory()->create();
    $this->get(route('app.coupons.edit', $coupon->id))->assertOk();
});

test('can update coupon', function() {
    $this->authenticate();
    $coupon = Coupon::factory()->create();
    $this->patch(route('app.coupons.update', $coupon->id), [
        'name' => 'Joe Smith',
       'email' => 'joe@joe.com'
    ])->assertRedirect(route('app.coupons.index'));

    $this->assertDatabaseHas('coupons', ['name' => 'Joe Smith']);
});

test('can delete coupon', function() {
    $this->authenticate();
    $coupon = Coupon::factory()->create();
    $this->delete(route('app.coupons.delete', $coupon->id))->assertRedirect(route('app.coupons.index'));

    $this->assertDatabaseCount('coupons', 0);
});