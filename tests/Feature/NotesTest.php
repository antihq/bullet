<?php

use App\Models\Note;
use App\Models\Task;
use App\Models\User;
use Livewire\Livewire;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertOk();
});

test('dashboard url redirects to notes', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertRedirect('/notes');
});

test('users can create an empty note', function () {
    $user = User::factory()->create();
    Livewire::actingAs($user)
        ->test('pages::notes.index')
        ->call('createNote')
        ->assertHasNoErrors();

    expect(Note::count())->toBe(1)
        ->and(Note::first()->user_id)->toBe($user->id)
        ->and(Task::count())->toBe(0);
});

test('users can delete a note', function () {
    $user = User::factory()->create();
    $note = Note::factory()->for($user)->create();

    Livewire::actingAs($user)
        ->test('pages::notes.index')
        ->call('deleteNote', $note->id);

    expect(Note::count())->toBe(0);
});

test('users can create a task in a note', function () {
    $user = User::factory()->create();
    $note = Note::factory()->for($user)->create();

    Livewire::actingAs($user)
        ->test('pages::notes.index')
        ->set('newTaskContent', 'Buy groceries')
        ->call('createTask', $note->id)
        ->assertHasNoErrors();

    expect(Task::count())->toBe(1)
        ->and(Task::first()->content)->toBe('Buy groceries')
        ->and(Task::first()->note_id)->toBe($note->id);
});

test('users can toggle task completion', function () {
    $user = User::factory()->create();
    $note = Note::factory()->for($user)->create();
    $task = Task::factory()->for($note)->create(['is_completed' => false]);

    Livewire::actingAs($user)
        ->test('pages::notes.index')
        ->call('toggleTask', $task->id);

    expect($task->fresh()->is_completed)->toBeTrue();
});

test('users can delete a task', function () {
    $user = User::factory()->create();
    $note = Note::factory()->for($user)->create();
    $task = Task::factory()->for($note)->create();

    Livewire::actingAs($user)
        ->test('pages::notes.index')
        ->call('deleteTask', $task->id);

    expect(Task::count())->toBe(0);
});

test('users cannot delete another users note', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $note = Note::factory()->for($otherUser)->create();

    Livewire::actingAs($user)
        ->test('pages::notes.index')
        ->call('deleteNote', $note->id);

    expect(Note::count())->toBe(1)
        ->and(Note::first()->id)->toBe($note->id);
});

test('users cannot delete another users task', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $note = Note::factory()->for($otherUser)->create();
    $task = Task::factory()->for($note)->create();

    Livewire::actingAs($user)
        ->test('pages::notes.index')
        ->call('deleteTask', $task->id);

    expect(Task::count())->toBe(1)
        ->and(Task::first()->id)->toBe($task->id);
});

test('users cannot toggle another users task', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $note = Note::factory()->for($otherUser)->create();
    $task = Task::factory()->for($note)->create(['is_completed' => false]);

    Livewire::actingAs($user)
        ->test('pages::notes.index')
        ->call('toggleTask', $task->id);

    expect($task->fresh()->is_completed)->toBeFalse();
});

test('users cannot add task to another users note', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $note = Note::factory()->for($otherUser)->create();

    Livewire::actingAs($user)
        ->test('pages::notes.index')
        ->set('newTaskContent', 'My task')
        ->call('createTask', $note->id);

    expect(Task::count())->toBe(0);
});

test('dashboard shows empty state when no notes', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test('pages::notes.index')
        ->assertOk()
        ->assertCount('notes', 0);
});

test('task requires content', function () {
    $user = User::factory()->create();
    $note = Note::factory()->for($user)->create();

    Livewire::actingAs($user)
        ->test('pages::notes.index')
        ->set('newTaskContent', '')
        ->call('createTask', $note->id)
        ->assertHasErrors(['newTaskContent' => 'required']);

    expect(Task::count())->toBe(0);
});

test('task content cannot exceed 255 characters', function () {
    $user = User::factory()->create();
    $note = Note::factory()->for($user)->create();

    Livewire::actingAs($user)
        ->test('pages::notes.index')
        ->set('newTaskContent', str_repeat('a', 256))
        ->call('createTask', $note->id)
        ->assertHasErrors(['newTaskContent' => 'max']);

    expect(Task::count())->toBe(0);
});

test('first note on a date shows date, not time', function () {
    $user = User::factory()->create();
    $note = Note::factory()->for($user)->create(['created_at' => now()]);

    Livewire::actingAs($user)
        ->test('pages::notes.index')
        ->assertSee($note->created_at->format('F j'))
        ->assertDontSee($note->created_at->format('g:i A'));
});

test('subsequent notes on same date show time', function () {
    $user = User::factory()->create();
    $date = now()->startOfDay();

    Note::factory()->for($user)->create(['created_at' => $date->copy()->addHours(10)]);
    Note::factory()->for($user)->create(['created_at' => $date->copy()->addHours(18)]);

    $response = Livewire::actingAs($user)
        ->test('pages::notes.index');

    $html = $response->html();

    expect($html)->toContain($date->format('F j'))
        ->and($html)->toMatch('/AM|PM/');
});

test('notes on different dates each show date', function () {
    $user = User::factory()->create();

    $note1 = Note::factory()->for($user)->create(['created_at' => now()->subDay()]);
    $note2 = Note::factory()->for($user)->create(['created_at' => now()]);

    Livewire::actingAs($user)
        ->test('pages::notes.index')
        ->assertSee($note1->created_at->format('F j'))
        ->assertSee($note2->created_at->format('F j'))
        ->assertDontSee($note1->created_at->format('g:i A'))
        ->assertDontSee($note2->created_at->format('g:i A'));
});

test('notes from previous year show year in date', function () {
    $user = User::factory()->create();
    $lastYear = now()->subYear()->year;

    $note = Note::factory()->for($user)->create(['created_at' => now()->subYear()]);

    Livewire::actingAs($user)
        ->test('pages::notes.index')
        ->assertSee((string) $lastYear);
});

test('multiple notes from previous year show time for subsequent', function () {
    $user = User::factory()->create();
    $lastYear = now()->subYear()->year;
    $date = now()->subYear()->startOfDay();

    Note::factory()->for($user)->create(['created_at' => $date->copy()->addHours(10)]);
    Note::factory()->for($user)->create(['created_at' => $date->copy()->addHours(18)]);

    $response = Livewire::actingAs($user)
        ->test('pages::notes.index');

    $html = $response->html();

    expect($html)->toContain((string) $lastYear)
        ->and($html)->toMatch('/AM|PM/');
});
