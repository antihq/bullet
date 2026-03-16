<?php

use App\Models\Board;
use App\Models\Note;
use App\Models\User;
use Livewire\Livewire;

test('guests are redirected from boards index', function () {
    $response = $this->get(route('boards.index'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can view boards index', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('boards.index'));
    $response->assertOk();
});

test('boards index shows users boards', function () {
    $user = User::factory()->create();
    Board::factory()->for($user)->create(['name' => 'Work Board']);
    Board::factory()->for($user)->create(['name' => 'Personal Board']);

    Livewire::actingAs($user)
        ->test('pages::boards.index')
        ->assertSee('Work Board')
        ->assertSee('Personal Board');
});

test('boards index shows note counts', function () {
    $user = User::factory()->create();
    $board = Board::factory()->for($user)->create(['name' => 'Board with Notes']);

    Note::factory()->for($user)->withBoard($board->id)->create();
    Note::factory()->for($user)->withBoard($board->id)->create();
    Note::factory()->for($user)->withBoard($board->id)->create();

    Livewire::actingAs($user)
        ->test('pages::boards.index')
        ->assertSee('3 notes');
});

test('boards index shows empty state when no boards', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test('pages::boards.index')
        ->assertSee('No boards yet')
        ->assertSee('Create your first board to organize your notes');
});

test('users can create a board via create page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('boards.create'))
        ->assertOk();

    Livewire::actingAs($user)
        ->test('pages::boards.create')
        ->set('name', 'My New Board')
        ->set('description', 'Board description')
        ->call('createBoard')
        ->assertRedirect(route('boards.show', Board::first()->id));

    expect(Board::count())->toBe(1)
        ->and(Board::first()->name)->toBe('My New Board')
        ->and(Board::first()->description)->toBe('Board description')
        ->and(Board::first()->user_id)->toBe($user->id);
});

test('board creation requires name', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test('pages::boards.create')
        ->set('name', '')
        ->set('description', 'Description')
        ->call('createBoard')
        ->assertHasErrors(['name']);
});

test('users can delete their board', function () {
    $user = User::factory()->create();
    $board = Board::factory()->for($user)->create();

    Livewire::actingAs($user)
        ->test('pages::boards.index')
        ->call('deleteBoard', $board->id);

    expect(Board::count())->toBe(0);
});

test('users cannot delete another users board', function () {
    $user = User::factory()->create();
    $otherUser = User::factory()->create();
    $board = Board::factory()->for($otherUser)->create();

    Livewire::actingAs($user)
        ->test('pages::boards.index')
        ->call('deleteBoard', $board->id);

    expect(Board::count())->toBe(1)
        ->and(Board::first()->id)->toBe($board->id);
});
