<?php

use Modules\Transactions\Models\Transaction;

uses(Tests\TestCase::class);

test('can see transaction list', function() {
    $this->authenticate();
   $this->get(route('app.transactions.index'))->assertOk();
});

test('can see transaction create page', function() {
    $this->authenticate();
   $this->get(route('app.transactions.create'))->assertOk();
});

test('can create transaction', function() {
    $this->authenticate();
   $this->post(route('app.transactions.store', [
       'name' => 'Joe',
       'email' => 'joe@joe.com'
   ]))->assertRedirect(route('app.transactions.index'));

   $this->assertDatabaseCount('transactions', 1);
});

test('can see transaction edit page', function() {
    $this->authenticate();
    $transaction = Transaction::factory()->create();
    $this->get(route('app.transactions.edit', $transaction->id))->assertOk();
});

test('can update transaction', function() {
    $this->authenticate();
    $transaction = Transaction::factory()->create();
    $this->patch(route('app.transactions.update', $transaction->id), [
        'name' => 'Joe Smith',
       'email' => 'joe@joe.com'
    ])->assertRedirect(route('app.transactions.index'));

    $this->assertDatabaseHas('transactions', ['name' => 'Joe Smith']);
});

test('can delete transaction', function() {
    $this->authenticate();
    $transaction = Transaction::factory()->create();
    $this->delete(route('app.transactions.delete', $transaction->id))->assertRedirect(route('app.transactions.index'));

    $this->assertDatabaseCount('transactions', 0);
});