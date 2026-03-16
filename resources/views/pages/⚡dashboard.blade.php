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

<div>
    <flux:heading size="xl">Dashboard</flux:heading>

    @foreach ($notes as $note)
        <div class="mt-8">
            <div class="flex items-center justify-between">
                <flux:heading>Note #{{ $loop->iteration }}</flux:heading>
                <flux:dropdown>
                    <flux:button variant="subtle" icon="ellipsis-horizontal" icon:variant="micro" size="sm" />
                    <flux:menu>
                        <flux:menu.item icon="trash" variant="danger" wire:click="deleteNote({{ $note->id }})">Delete</flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
            </div>

            <flux:table class="mt-2">
                <flux:table.rows>
                    @foreach ($note->tasks as $task)
                        <flux:table.row :key="$task->id">
                            <flux:table.cell class="flex items-start gap-3">
                                <flux:checkbox wire:model.live="task.is_completed" wire:change="toggleTask({{ $task->id }})" />
                                <span class="{{ $task->is_completed ? 'line-through' : '' }} flex-1">{{ $task->content }}</span>
                            </flux:table.cell>
                            <flux:table.cell align="end">
                                <flux:dropdown>
                                    <flux:button variant="subtle" icon="ellipsis-horizontal" icon:variant="micro" size="sm" inset="top bottom" />
                                    <flux:menu>
                                        <flux:menu.item icon="trash" variant="danger" wire:click="deleteTask({{ $task->id }})">Delete</flux:menu.item>
                                    </flux:menu>
                                </flux:dropdown>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                    <flux:table.row>
                        <flux:table.cell colspan="2">
                            <form wire:submit="createTask({{ $note->id }})">
                                <flux:composer wire:model="newTaskContent" submit="enter" rows="1" inline label="Task" label:sr-only placeholder="Add a task...">
                                    <x-slot name="actionsTrailing">
                                        <flux:button type="submit" size="sm" variant="subtle" icon="plus" />
                                    </x-slot>
                                </flux:composer>
                            </form>
                        </flux:table.cell>
                    </flux:table.row>
                </flux:table.rows>
            </flux:table>
        </div>
    @endforeach

    <div class="mt-6">
        <flux:heading>New Note</flux:heading>
        <flux:table>
            <flux:table.rows>
                <flux:table.row>
                    <flux:table.cell>
                        <form wire:submit="createNoteWithTask">
                            <flux:composer wire:model="newNoteTaskContent" submit="enter" rows="1" inline label="Task" label:sr-only placeholder="Add a task to create a new note...">
                                <x-slot name="actionsTrailing">
                                    <flux:button type="submit" size="sm" variant="subtle" icon="plus" />
                                </x-slot>
                            </flux:composer>
                        </form>
                    </flux:table.cell>
                </flux:table.row>
            </flux:table.rows>
        </flux:table>
    </div>
</div>
