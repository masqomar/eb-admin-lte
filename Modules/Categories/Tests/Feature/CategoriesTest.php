<?php

use Modules\Categories\Models\Category;

uses(Tests\TestCase::class);

test('can see category list', function() {
    $this->authenticate();
   $this->get(route('app.categories.index'))->assertOk();
});

test('can see category create page', function() {
    $this->authenticate();
   $this->get(route('app.categories.create'))->assertOk();
});

test('can create category', function() {
    $this->authenticate();
   $this->post(route('app.categories.store', [
       'name' => 'Joe',
       'email' => 'joe@joe.com'
   ]))->assertRedirect(route('app.categories.index'));

   $this->assertDatabaseCount('categories', 1);
});

test('can see category edit page', function() {
    $this->authenticate();
    $category = Category::factory()->create();
    $this->get(route('app.categories.edit', $category->id))->assertOk();
});

test('can update category', function() {
    $this->authenticate();
    $category = Category::factory()->create();
    $this->patch(route('app.categories.update', $category->id), [
        'name' => 'Joe Smith',
       'email' => 'joe@joe.com'
    ])->assertRedirect(route('app.categories.index'));

    $this->assertDatabaseHas('categories', ['name' => 'Joe Smith']);
});

test('can delete category', function() {
    $this->authenticate();
    $category = Category::factory()->create();
    $this->delete(route('app.categories.delete', $category->id))->assertRedirect(route('app.categories.index'));

    $this->assertDatabaseCount('categories', 0);
});