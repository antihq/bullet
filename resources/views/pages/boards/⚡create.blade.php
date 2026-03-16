<?php

use App\Models\Board;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

new class extends Component
{
    public string $name = '';

    public string $description = '';

    public function createBoard(): Redirector
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $board = Board::create([
            'user_id' => auth()->id(),
            'name' => $this->name,
            'description' => $this->description,
            'position' => auth()->user()->boards()->count(),
        ]);

        return redirect()->route('boards.show', $board->id);
    }
}
?>

<div class="p-6">
    <flux:header>
        <div>
            <flux:link href="{{ route('boards.index') }}">
                <flux:button variant="subtle" icon="arrow-left">Boards</flux:button>
            </flux:link>
            <flux:heading size="xl" class="mt-2">Create Board</flux:heading>
        </div>
        <flux:link href="{{ route('boards.index') }}">
            <flux:button variant="subtle">Cancel</flux:button>
        </flux:link>
    </flux:header>

    <div class="max-w-2xl mt-6">
        <form wire:submit="createBoard">
            <flux:input wire:model="name" label="Name" placeholder="Enter board name" required />
            <flux:textarea wire:model="description" label="Description" placeholder="Optional description" class="mt-4" />
            <flux:button type="submit" class="mt-6">Create Board</flux:button>
        </form>
    </div>
</div>
