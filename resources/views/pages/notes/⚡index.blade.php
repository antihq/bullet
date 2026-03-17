<?php

use App\Models\Note;
use Illuminate\Support\Collection;
use Livewire\Component;

new class extends Component
{
    public Collection $notes;

    public array $notesByDate = [];

    public function mount(): void
    {
        $this->loadNotes();
    }

    public function loadNotes(): void
    {
        $this->notes = auth()->user()->notes()->with('tasks')->get();

        if ($this->notes->isEmpty()) {
            Note::create([
                'user_id' => auth()->id(),
            ]);
            $this->notes = auth()->user()->notes()->with('tasks')->get();
        }

        $this->notesByDate = $this->notes
            ->groupBy(fn ($note) => $note->created_at->format('Y-m-d'))
            ->map(fn ($notes) => $notes->first()->id)
            ->toArray();
    }

    public function shouldShowTime(Note $note): bool
    {
        $dateKey = $note->created_at->format('Y-m-d');

        return isset($this->notesByDate[$dateKey]) && $this->notesByDate[$dateKey] !== $note->id;
    }

    public function createNote(): void
    {
        Note::create([
            'user_id' => auth()->id(),
        ]);
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
}
?>

<div>
    <div class="flex items-center justify-between">
        <flux:heading size="xl">Notes</flux:heading>
        <flux:button wire:click="createNote" icon="plus">Add Note</flux:button>
    </div>

    @foreach ($notes as $note)
        <div class="mt-6">
            <div class="flex items-center justify-between">
                <flux:heading x-data="{ 
    date: new Date('{{ $note->created_at->toIso8601String() }}'),
    format(type) {
        if (type === 'time') {
            return this.date.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
        }
        const options = this.date.getFullYear() === new Date().getFullYear()
            ? { month: 'long', day: 'numeric' }
            : { month: 'long', day: 'numeric', year: 'numeric' };
        return this.date.toLocaleDateString([], options);
    }
}">
                    @if ($this->shouldShowTime($note))
                        <span x-text="format('time')"></span>
                    @else
                        <span x-text="format('date')"></span>
                    @endif
                </flux:heading>
                <flux:dropdown>
                    <flux:button variant="subtle" icon="ellipsis-horizontal" icon:variant="micro" size="sm" />
                    <flux:menu>
                        <flux:menu.item icon="trash" variant="danger" wire:click="deleteNote({{ $note->id }})">Delete</flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
            </div>

            <livewire:note :note="$note" :key="$note->id" class="mt-2" />
        </div>
    @endforeach
</div>
