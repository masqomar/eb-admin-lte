<?php

use Modules\Students\Models\Student;

uses(Tests\TestCase::class);

test('can see student list', function() {
    $this->authenticate();
   $this->get(route('app.students.index'))->assertOk();
});

test('can see student create page', function() {
    $this->authenticate();
   $this->get(route('app.students.create'))->assertOk();
});

test('can create student', function() {
    $this->authenticate();
   $this->post(route('app.students.store', [
       'name' => 'Joe',
       'email' => 'joe@joe.com'
   ]))->assertRedirect(route('app.students.index'));

   $this->assertDatabaseCount('students', 1);
});

test('can see student edit page', function() {
    $this->authenticate();
    $student = Student::factory()->create();
    $this->get(route('app.students.edit', $student->id))->assertOk();
});

test('can update student', function() {
    $this->authenticate();
    $student = Student::factory()->create();
    $this->patch(route('app.students.update', $student->id), [
        'name' => 'Joe Smith',
       'email' => 'joe@joe.com'
    ])->assertRedirect(route('app.students.index'));

    $this->assertDatabaseHas('students', ['name' => 'Joe Smith']);
});

test('can delete student', function() {
    $this->authenticate();
    $student = Student::factory()->create();
    $this->delete(route('app.students.delete', $student->id))->assertRedirect(route('app.students.index'));

    $this->assertDatabaseCount('students', 0);
});