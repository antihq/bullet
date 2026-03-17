<?php

use App\Models\Note;
use App\Models\Task;
use Livewire\Component;

new class extends Component
{
    public Note $note;

    public string $newTaskContent = '';

    public function createTask(): void
    {
        if ($this->note->user_id !== auth()->id()) {
            abort(403);
        }

        $this->validate([
            'newTaskContent' => 'required|string|max:255',
        ]);

        Task::create([
            'note_id' => $this->note->id,
            'content' => $this->newTaskContent,
            'position' => $this->note->tasks->count(),
        ]);

        $this->newTaskContent = '';
        $this->note->refresh();
    }

    public function toggleTask(int $taskId): void
    {
        $task = Task::with('note')->findOrFail($taskId);
        if ($task->note->user_id !== auth()->id()) {
            abort(403);
        }
        $task->update(['is_completed' => ! $task->is_completed]);
        $this->note->refresh();
    }

    public function cancelTask(int $taskId): void
    {
        $task = Task::with('note')->findOrFail($taskId);
        if ($task->note->user_id !== auth()->id()) {
            abort(403);
        }
        $task->update(['is_cancelled' => ! $task->is_cancelled]);
        $this->note->refresh();
    }

    public function deleteTask(int $taskId): void
    {
        $task = Task::with('note')->findOrFail($taskId);
        if ($task->note->user_id !== auth()->id()) {
            abort(403);
        }
        $task->delete();
        $this->note->refresh();
    }
}
?>

<div>
    <flux:table>
        <flux:table.rows>
            @foreach ($note->tasks as $task)
                <flux:table.row :key="$task->id">
                    <flux:table.cell class="flex items-start gap-3" :variant="$task->is_completed || $task->is_cancelled ? 'default' : 'strong'">
                        <flux:checkbox :checked="$task->is_completed" :disabled="$task->is_cancelled" wire:change="toggleTask({{ $task->id }})" />
                        <span class="{{ $task->is_completed || $task->is_cancelled ? 'line-through' : '' }} flex-1">{{ $task->content }}</span>
                    </flux:table.cell>
                    <flux:table.cell align="end">
                        <flux:dropdown>
                            <flux:button variant="subtle" icon="ellipsis-horizontal" icon:variant="micro" size="sm" inset="top bottom" />
                            <flux:menu>
                                <flux:menu.item wire:click="cancelTask({{ $task->id }})">Cancel</flux:menu.item>
                                <flux:menu.item icon="trash" variant="danger" wire:click="deleteTask({{ $task->id }})">Delete</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
            <flux:table.row>
                <flux:table.cell colspan="2">
                    <form wire:submit="createTask">
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