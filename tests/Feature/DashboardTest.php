<?php

use App\Models\Board;
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

test('users can create a note with a task', function () {
    $user = User::factory()->create();
    Livewire::actingAs($user)
        ->test('pages::dashboard')
        ->set('newNoteTaskContent', 'Buy groceries')
        ->call('createNoteWithTask')
        ->assertHasNoErrors();

    expect(Note::count())->toBe(1)
        ->and(Note::first()->user_id)->toBe($user->id)
        ->and(Task::count())->toBe(1)
        ->and(Task::first()->content)->toBe('Buy groceries')
        ->and(Task::first()->note_id)->toBe(Note::first()->id);
});

test('users can delete a note', function () {
    $user = User::factory()->create();
    $note = Note::factory()->for($user)->create();

    Livewire::actingAs($user)
        ->test('pages::dashboard')
        ->call('deleteNote', $note->id);

    expect(Note::count())->toBe(0);
});

test('users can create a task in a note', function () {
    $user = User::factory()->create();
    $note = Note::factory()->for($user)->create();

    Livewire::actingAs($user)
        ->test('pages::dashboard')
        ->set('activeNoteId', $note->id)
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
        ->test('pages::dashboard')
        ->call('toggleTask', $task->id);

    expect($task->fresh()->is_completed)->toBeTrue();
});

test('users can delete a task', function () {
    $user = User::factory()->create();
    $note = Note::factory()->for($user)->create();
    $task = Task::factory()->for($note)->create();

    Livewire::actingAs($user)
        ->test('pages::dashboard')
        ->call('deleteTask', $task->id);

    expect(Task::count())->toBe(0);
});

test('users cannot delete another users note', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $note = Note::factory()->for($otherUser)->create();

    Livewire::actingAs($user)
        ->test('pages::dashboard')
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
        ->test('pages::dashboard')
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
        ->test('pages::dashboard')
        ->call('toggleTask', $task->id);

    expect($task->fresh()->is_completed)->toBeFalse();
});

test('users cannot add task to another users note', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $note = Note::factory()->for($otherUser)->create();

    Livewire::actingAs($user)
        ->test('pages::dashboard')
        ->set('activeNoteId', $note->id)
        ->set('newTaskContent', 'My task')
        ->call('createTask', $note->id);

    expect(Task::count())->toBe(0);
});

test('dashboard only shows unassigned notes', function () {
    $user = User::factory()->create();
    $board = Board::factory()->for($user)->create();

    Note::factory()->for($user)->withBoard($board->id)->create();
    Note::factory()->for($user)->withBoard($board->id)->create();
    Note::factory()->for($user)->unassigned()->create();

    Livewire::actingAs($user)
        ->test('pages::dashboard')
        ->assertCount('notes', 1);
});

test('users can move notes to a board', function () {
    $user = User::factory()->create();
    $board = Board::factory()->for($user)->create();
    $note = Note::factory()->for($user)->unassigned()->create();

    Livewire::actingAs($user)
        ->test('pages::dashboard')
        ->call('moveNoteToBoard', $note->id, $board->id);

    expect($note->fresh()->board_id)->toBe($board->id);
});

test('users can delete their own board', function () {
    $user = User::factory()->create();
    $board = Board::factory()->for($user)->create();

    Livewire::actingAs($user)
        ->test('pages::dashboard')
        ->call('deleteBoard', $board->id);

    expect(Board::count())->toBe(0);
});

test('users cannot delete another users board', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $board = Board::factory()->for($otherUser)->create();

    Livewire::actingAs($user)
        ->test('pages::dashboard')
        ->call('deleteBoard', $board->id);

    expect(Board::count())->toBe(1);
});

test('dashboard shows user boards', function () {
    $user = User::factory()->create();
    Board::factory()->for($user)->create(['name' => 'Work']);

    Livewire::actingAs($user)
        ->test('pages::dashboard')
        ->assertCount('boards', 1)
        ->assertSee('Work');
});

test('dashboard shows empty state when no boards', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test('pages::dashboard')
        ->assertCount('boards', 0)
        ->assertSee('No boards yet');
});
