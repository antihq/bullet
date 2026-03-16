<?php

use App\Models\Board;
use App\Models\Note;
use App\Models\Task;
use Illuminate\Support\Collection;
use Livewire\Component;

new class extends Component
{
    public Collection $notes;

    public Collection $boards;

    public int $activeNoteId = 0;

    public string $newTaskContent = '';

    public string $newNoteTaskContent = '';

    public function mount(): void
    {
        $this->loadNotes();
        $this->loadBoards();
    }

    public function loadNotes(): void
    {
        $this->notes = auth()->user()->notes()->whereNull('board_id')->with('tasks')->get();
    }

    public function loadBoards(): void
    {
        $this->boards = auth()->user()->boards()->with('notes')->get();
    }

    public function createNoteWithTask(): void
    {
        $this->validate([
            'newNoteTaskContent' => 'required|string|max:255',
        ]);

        $note = Note::create([
            'user_id' => auth()->id(),
            'position' => $this->notes->count(),
        ]);

        Task::create([
            'note_id' => $note->id,
            'content' => $this->newNoteTaskContent,
            'position' => 0,
        ]);

        $this->newNoteTaskContent = '';
        $this->loadNotes();
    }

    public function deleteNote(int $noteId): void
    {
        $note = Note::findOrFail($noteId);
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }
        $note->delete();
        $this->loadNotes();
    }

    public function moveNoteToBoard(int $noteId, int $boardId): void
    {
        $note = Note::findOrFail($noteId);
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }

        $board = Board::findOrFail($boardId);
        if ($board->user_id !== auth()->id()) {
            abort(403);
        }

        $note->update(['board_id' => $boardId]);
        $this->loadNotes();
    }

    public function createTask(int $noteId): void
    {
        $this->validate([
            'newTaskContent' => 'required|string|max:255',
        ]);

        $note = Note::findOrFail($noteId);
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }
        Task::create([
            'note_id' => $noteId,
            'content' => $this->newTaskContent,
            'position' => $note->tasks->count(),
        ]);

        $this->newTaskContent = '';
        $this->loadNotes();
    }

    public function toggleTask(int $taskId): void
    {
        $task = Task::with('note')->findOrFail($taskId);
        if ($task->note->user_id !== auth()->id()) {
            abort(403);
        }
        $task->update(['is_completed' => ! $task->is_completed]);
        $this->loadNotes();
    }

    public function deleteTask(int $taskId): void
    {
        $task = Task::with('note')->findOrFail($taskId);
        if ($task->note->user_id !== auth()->id()) {
            abort(403);
        }
        $task->delete();
        $this->loadNotes();
    }

    public function deleteBoard(int $boardId): void
    {
        $board = Board::findOrFail($boardId);
        if ($board->user_id !== auth()->id()) {
            abort(403);
        }
        $board->delete();
        $this->loadBoards();
    }
}
?>

<div class="p-6">
    <flux:header>
        <flux:heading size="xl">Dashboard</flux:heading>
        <flux:link href="{{ route('boards.index') }}">
            <flux:button>Boards</flux:button>
        </flux:link>
    </flux:header>

    <flux:heading size="lg" class="mt-8 mb-4">Unassigned Notes</flux:heading>

    @foreach ($notes as $note)
        <div class="mb-6">
            <div class="flex items-center justify-between mb-2">
                <flux:heading size="md">Note #{{ $loop->iteration }}</flux:heading>
                <flux:dropdown>
                    <flux:button variant="subtle" icon="ellipsis-horizontal" size="sm" />
                    <flux:menu>
                        @foreach (auth()->user()->boards as $board)
                            <flux:menu.item wire:click="moveNoteToBoard({{ $note->id }}, {{ $board->id }})">{{ $board->name }}</flux:menu.item>
                        @endforeach
                        <flux:menu.item icon="trash" wire:click="deleteNote({{ $note->id }})">Delete note</flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
            </div>

            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Task</flux:table.column>
                    <flux:table.column class="w-16"></flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach ($note->tasks as $task)
                        <flux:table.row :key="$task->id">
                            <flux:table.cell class="flex items-start gap-3">
                                <flux:checkbox wire:model.live="task.is_completed" wire:change="toggleTask({{ $task->id }})" />
                                <span class="{{ $task->is_completed ? 'line-through text-zinc-400' : '' }} flex-1">{{ $task->content }}</span>
                            </flux:table.cell>
                            <flux:table.cell>
                                <flux:button variant="subtle" icon="trash" size="sm" wire:click="deleteTask({{ $task->id }})" />
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>

                <flux:table.rows>
                    @if ($activeNoteId === $note->id)
                        <flux:table.row>
                            <flux:table.cell colspan="2">
                                <form wire:submit="createTask({{ $note->id }})">
                                    <flux:composer wire:model="newTaskContent" submit="enter" placeholder="Add a task..." />
                                </form>
                            </flux:table.cell>
                        </flux:table.row>
                    @else
                        <flux:table.row>
                            <flux:table.cell colspan="2">
                                <flux:button variant="subtle" icon="plus" size="sm" align="start" wire:click="$set('activeNoteId', {{ $note->id }})">
                                    Add task
                                </flux:button>
                            </flux:table.cell>
                        </flux:table.row>
                    @endif
                </flux:table.rows>
            </flux:table>
        </div>
    @endforeach

    <div class="mb-8">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>New Note</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                <flux:table.row>
                    <flux:table.cell>
                        <form wire:submit="createNoteWithTask">
                            <flux:composer wire:model="newNoteTaskContent" submit="enter" placeholder="Add a task to create a new note..." />
                        </form>
                    </flux:table.cell>
                </flux:table.row>
            </flux:table.rows>
        </flux:table>
    </div>

    <flux:heading size="lg" class="mt-8 mb-4">Boards</flux:heading>

    @if ($boards->isEmpty())
        <div class="text-center py-12">
            <flux:icon name="folder" class="w-16 h-16 mx-auto text-zinc-400 mb-4" />
            <flux:heading size="lg" class="text-zinc-600">No boards yet</flux:heading>
            <flux:text class="text-zinc-500 mt-2">Create your first board to organize your notes</flux:text>
            <div class="mt-4">
                <flux:link href="{{ route('boards.create') }}">
                    <flux:button icon="plus">Create Board</flux:button>
                </flux:link>
            </div>
        </div>
    @else
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Name</flux:table.column>
                <flux:table.column>Description</flux:table.column>
                <flux:table.column>Notes</flux:table.column>
                <flux:table.column class="w-32"></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($boards as $board)
                    <flux:table.row :key="$board->id">
                        <flux:table.cell>
                            <flux:link href="{{ route('boards.show', $board->id) }}">
                                {{ $board->name }}
                            </flux:link>
                        </flux:table.cell>
                        <flux:table.cell class="text-zinc-500">
                            {{ $board->description ?? '-' }}
                        </flux:table.cell>
                        <flux:table.cell>
                            {{ $board->notes->count() }}
                        </flux:table.cell>
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" icon="ellipsis-horizontal" size="sm" />
                                <flux:menu>
                                    <flux:menu.item icon="trash" wire:click="deleteBoard({{ $board->id }})">Delete board</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    @endif
</div>
