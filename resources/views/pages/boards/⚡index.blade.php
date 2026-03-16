<?php

use App\Models\Board;
use Illuminate\Support\Collection;
use Livewire\Component;

new class extends Component
{
    public Collection $boards;

    public function mount(): void
    {
        $this->loadBoards();
    }

    public function loadBoards(): void
    {
        $this->boards = auth()->user()->boards()->with('notes')->get();
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
        <div>
            <flux:link href="{{ route('dashboard') }}">
                <flux:button variant="subtle" icon="arrow-left">Dashboard</flux:button>
            </flux:link>
            <flux:heading size="xl" class="mt-2">Boards</flux:heading>
        </div>
        <flux:link href="{{ route('boards.create') }}">
            <flux:button icon="plus">Create Board</flux:button>
        </flux:link>
    </flux:header>

    @if ($boards->isEmpty())
        <div class="text-center py-12">
            <flux:icon name="folder" class="w-16 h-16 mx-auto text-zinc-400 mb-4" />
            <flux:heading size="lg" class="text-zinc-600">No boards yet</flux:heading>
            <flux:text class="text-zinc-500 mt-2">Create your first board to organize your notes</flux:text>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
            @foreach ($boards as $board)
                <flux:card class="relative">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <flux:link href="{{ route('boards.show', $board->id) }}">
                                <flux:heading size="md">{{ $board->name }}</flux:heading>
                            </flux:link>
                            @if ($board->description)
                                <flux:text size="sm" class="text-zinc-500 mt-1">{{ $board->description }}</flux:text>
                            @endif
                        </div>
                        <flux:dropdown>
                            <flux:button variant="subtle" icon="ellipsis-horizontal" size="sm" />
                            <flux:menu>
                                <flux:menu.item icon="trash" wire:click="deleteBoard({{ $board->id }})">Delete board</flux:menu.item>
                            </flux:menu>
                        </flux:dropdown>
                    </div>
                    <div class="flex items-center text-zinc-500">
                        <flux:icon name="document-text" class="w-4 h-4" />
                        <flux:text size="sm" class="ml-2">{{ $board->notes->count() }} note{{ $board->notes->count() !== 1 ? 's' : '' }}</flux:text>
                    </div>
                </flux:card>
            @endforeach
        </div>
    @endif
</div>
