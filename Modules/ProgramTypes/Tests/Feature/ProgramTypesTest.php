<?php

use Modules\ProgramTypes\Models\ProgramType;

uses(Tests\TestCase::class);

test('can see programtype list', function() {
    $this->authenticate();
   $this->get(route('app.programtypes.index'))->assertOk();
});

test('can see programtype create page', function() {
    $this->authenticate();
   $this->get(route('app.programtypes.create'))->assertOk();
});

test('can create programtype', function() {
    $this->authenticate();
   $this->post(route('app.programtypes.store', [
       'name' => 'Joe',
       'email' => 'joe@joe.com'
   ]))->assertRedirect(route('app.programtypes.index'));

   $this->assertDatabaseCount('programtypes', 1);
});

test('can see programtype edit page', function() {
    $this->authenticate();
    $programtype = ProgramType::factory()->create();
    $this->get(route('app.programtypes.edit', $programtype->id))->assertOk();
});

test('can update programtype', function() {
    $this->authenticate();
    $programtype = ProgramType::factory()->create();
    $this->patch(route('app.programtypes.update', $programtype->id), [
        'name' => 'Joe Smith',
       'email' => 'joe@joe.com'
    ])->assertRedirect(route('app.programtypes.index'));

    $this->assertDatabaseHas('programtypes', ['name' => 'Joe Smith']);
});

test('can delete programtype', function() {
    $this->authenticate();
    $programtype = ProgramType::factory()->create();
    $this->delete(route('app.programtypes.delete', $programtype->id))->assertRedirect(route('app.programtypes.index'));

    $this->assertDatabaseCount('program_types', 0);
});