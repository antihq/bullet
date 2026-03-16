<?php

use App\Models\Board;
use App\Models\Note;
use App\Models\Task;
use App\Models\User;
use Livewire\Livewire;

test('guests are redirected from board show', function () {
    $board = Board::factory()->create();

    $response = $this->get(route('boards.show', $board->id));
    $response->assertRedirect(route('login'));
});

test('users can view their board', function () {
    $user = User::factory()->create();
    $board = Board::factory()->for($user)->create(['name' => 'My Board']);

    $response = $this->actingAs($user)->get(route('boards.show', $board->id));
    $response->assertOk();
});

test('board show displays board name and description', function () {
    $user = User::factory()->create();
    $board = Board::factory()->for($user)->create([
        'name' => 'Work Board',
        'description' => 'Work-related tasks',
    ]);

    Livewire::actingAs($user)
        ->test('pages::boards.show', ['board' => $board])
        ->assertSee('Work Board')
        ->assertSee('Work-related tasks');
});

test('board show only displays boards notes', function () {
    $user = User::factory()->create();
    $board = Board::factory()->for($user)->create(['name' => 'Work Board']);
    $otherBoard = Board::factory()->for($user)->create(['name' => 'Personal Board']);

    Note::factory()->for($user)->withBoard($board->id)->create();
    Note::factory()->for($user)->withBoard($board->id)->create();
    Note::factory()->for($user)->withBoard($otherBoard->id)->create();
    Note::factory()->for($user)->unassigned()->create();

    Livewire::actingAs($user)
        ->test('pages::boards.show', ['board' => $board])
        ->assertCount('notes', 2);
});

test('users cannot view another users board', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $board = Board::factory()->for($otherUser)->create();

    $response = $this->actingAs($user)->get(route('boards.show', $board->id));
    $response->assertStatus(403);
});

test('users can create notes in a board', function () {
    $user = User::factory()->create();
    $board = Board::factory()->for($user)->create();

    Livewire::actingAs($user)
        ->test('pages::boards.show', ['board' => $board])
        ->set('newNoteTaskContent', 'New task')
        ->call('createNoteWithTask')
        ->assertHasNoErrors();

    expect(Note::count())->toBe(1)
        ->and(Note::first()->board_id)->toBe($board->id)
        ->and(Task::count())->toBe(1)
        ->and(Task::first()->content)->toBe('New task');
});

test('users can move note to another board', function () {
    $user = User::factory()->create();
    $board1 = Board::factory()->for($user)->create(['name' => 'Board 1']);
    $board2 = Board::factory()->for($user)->create(['name' => 'Board 2']);
    $note = Note::factory()->for($user)->withBoard($board1->id)->create();

    Livewire::actingAs($user)
        ->test('pages::boards.show', ['board' => $board1])
        ->call('moveNoteToBoard', $note->id, $board2->id);

    expect($note->fresh()->board_id)->toBe($board2->id);
});

test('users can move note to unassigned', function () {
    $user = User::factory()->create();
    $board = Board::factory()->for($user)->create();
    $note = Note::factory()->for($user)->withBoard($board->id)->create();

    Livewire::actingAs($user)
        ->test('pages::boards.show', ['board' => $board])
        ->call('moveNoteToBoard', $note->id, 0);

    expect($note->fresh()->board_id)->toBeNull();
});

test('users can delete notes from a board', function () {
    $user = User::factory()->create();
    $board = Board::factory()->for($user)->create();
    $note = Note::factory()->for($user)->withBoard($board->id)->create();

    Livewire::actingAs($user)
        ->test('pages::boards.show', ['board' => $board])
        ->call('deleteNote', $note->id);

    expect(Note::count())->toBe(0);
});

test('users can create tasks in board notes', function () {
    $user = User::factory()->create();
    $board = Board::factory()->for($user)->create();
    $note = Note::factory()->for($user)->withBoard($board->id)->create();

    Livewire::actingAs($user)
        ->test('pages::boards.show', ['board' => $board])
        ->set('activeNoteId', $note->id)
        ->set('newTaskContent', 'New task')
        ->call('createTask', $note->id)
        ->assertHasNoErrors();

    expect(Task::count())->toBe(1)
        ->and(Task::first()->content)->toBe('New task');
});

test('users can toggle tasks in board notes', function () {
    $user = User::factory()->create();
    $board = Board::factory()->for($user)->create();
    $note = Note::factory()->for($user)->withBoard($board->id)->create();
    $task = Task::factory()->for($note)->create(['is_completed' => false]);

    Livewire::actingAs($user)
        ->test('pages::boards.show', ['board' => $board])
        ->call('toggleTask', $task->id);

    expect($task->fresh()->is_completed)->toBeTrue();
});

test('users can delete tasks from board notes', function () {
    $user = User::factory()->create();
    $board = Board::factory()->for($user)->create();
    $note = Note::factory()->for($user)->withBoard($board->id)->create();
    $task = Task::factory()->for($note)->create();

    Livewire::actingAs($user)
        ->test('pages::boards.show', ['board' => $board])
        ->call('deleteTask', $task->id);

    expect(Task::count())->toBe(0);
});
