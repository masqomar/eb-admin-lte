<?php

use Modules\Programs\Models\Program;

uses(Tests\TestCase::class);

test('can see program list', function() {
    $this->authenticate();
   $this->get(route('app.programs.index'))->assertOk();
});

test('can see program create page', function() {
    $this->authenticate();
   $this->get(route('app.programs.create'))->assertOk();
});

test('can create program', function() {
    $this->authenticate();
   $this->post(route('app.programs.store', [
       'name' => 'Joe',
       'email' => 'joe@joe.com'
   ]))->assertRedirect(route('app.programs.index'));

   $this->assertDatabaseCount('programs', 1);
});

test('can see program edit page', function() {
    $this->authenticate();
    $program = Program::factory()->create();
    $this->get(route('app.programs.edit', $program->id))->assertOk();
});

test('can update program', function() {
    $this->authenticate();
    $program = Program::factory()->create();
    $this->patch(route('app.programs.update', $program->id), [
        'name' => 'Joe Smith',
       'email' => 'joe@joe.com'
    ])->assertRedirect(route('app.programs.index'));

    $this->assertDatabaseHas('programs', ['name' => 'Joe Smith']);
});

test('can delete program', function() {
    $this->authenticate();
    $program = Program::factory()->create();
    $this->delete(route('app.programs.delete', $program->id))->assertRedirect(route('app.programs.index'));

    $this->assertDatabaseCount('programs', 0);
});