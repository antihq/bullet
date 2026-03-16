<?php

use App\Models\Note;
use App\Models\Task;
use Illuminate\Support\Collection;
use Livewire\Component;

new class extends Component
{
    public Collection $notes;

    public int $activeNoteId = 0;

    public string $newTaskContent = '';

    public string $newNoteTaskContent = '';

    public function mount(): void
    {
        $this->loadNotes();
    }

    public function loadNotes(): void
    {
        $this->notes = auth()->user()->notes()->with('tasks')->get();
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
}
?>

<div class="p-6">
    <flux:heading size="xl">Dashboard</flux:heading>

    <flux:kanban class="mt-6">
        @foreach ($notes as $note)
            <flux:kanban.column>
                <flux:kanban.column.header :count="$note->tasks->count()">
                    <x-slot name="actions">
                        <flux:dropdown>
                            <flux:button variant="subtle" icon="ellipsis-horizontal" size="sm" />
                            <flux:menu>
                                <flux:menu.item icon="trash" wire:click="deleteNote({{ $note->id }})">Delete note</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </x-slot>
                </flux:kanban.column.header>

                <flux:kanban.column.cards>
                    @foreach ($note->tasks as $task)
                        <flux:kanban.card as="div">
                            <div class="flex items-start gap-3">
                                <flux:checkbox wire:model.live="task.is_completed" wire:change="toggleTask({{ $task->id }})" />
                                <span class="{{ $task->is_completed ? 'line-through text-zinc-400' : '' }} flex-1">{{ $task->content }}</span>
                            </div>
                        </flux:kanban.card>
                    @endforeach
                </flux:kanban.column.cards>

                <flux:kanban.column.footer>
                    @if ($activeNoteId === $note->id)
                        <form wire:submit="createTask({{ $note->id }})">
                            <flux:composer wire:model="newTaskContent" submit="enter" placeholder="Add a task..." />
                        </form>
                    @else
                        <flux:button variant="subtle" icon="plus" size="sm" align="start" wire:click="$set('activeNoteId', {{ $note->id }})">
                            Add task
                        </flux:button>
                    @endif
                </flux:kanban.column.footer>
            </flux:kanban.column>
        @endforeach

        <flux:kanban.column>
            <flux:kanban.column.header heading="New note" count="0" />
            <flux:kanban.column.cards>
                <form wire:submit="createNoteWithTask">
                    <flux:composer wire:model="newNoteTaskContent" submit="enter" placeholder="Add a task to create a new note..." />
                </form>
            </flux:kanban.column.cards>
        </flux:kanban.column>
    </flux:kanban>
</div>