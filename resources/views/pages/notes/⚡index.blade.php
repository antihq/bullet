<?php

use App\Models\Note;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;

new class extends Component
{
    #[Url]
    public int $page = 1;

    public Collection $notes;

    public array $notesByDate = [];

    public bool $hasMorePages = false;

    public function mount(): void
    {
        $this->loadNotes();
    }

    public function loadNotes(): void
    {
        $user = auth()->user();

        $distinctDates = $user->notes()
            ->selectRaw('DISTINCT DATE(created_at) as date')
            ->reorder()
            ->orderByDesc('date')
            ->pluck('date');

        if ($distinctDates->isEmpty()) {
            Note::create(['user_id' => $user->id]);
            $distinctDates = $user->notes()
                ->selectRaw('DISTINCT DATE(created_at) as date')
                ->reorder()
                ->orderByDesc('date')
                ->pluck('date');
        }

        $maxPage = max(1, (int) ceil($distinctDates->count() / 7));
        $this->page = max(1, min($this->page, $maxPage));

        $pageDates = $distinctDates->slice(($this->page - 1) * 7, 7)->values();

        $this->notes = $user->notes()
            ->with('tasks')
            ->where(function ($query) use ($pageDates) {
                foreach ($pageDates as $date) {
                    $query->orWhereDate('created_at', $date);
                }
            })
            ->orderByDesc('created_at')
            ->get();

        $this->hasMorePages = $distinctDates->count() > $this->page * 7;

        $this->notesByDate = $this->notes
            ->groupBy(fn ($note) => $note->created_at->format('Y-m-d'))
            ->map(fn ($notes) => $notes->first()->id)
            ->toArray();
    }

    public function nextPage(): void
    {
        if ($this->hasMorePages) {
            $this->page++;
            $this->loadNotes();
        }
    }

    public function previousPage(): void
    {
        if ($this->page > 1) {
            $this->page--;
            $this->loadNotes();
        }
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
        $this->page = 1;
        $this->loadNotes();
    }

    public function deleteNote(int $noteId): void
    {
        $note = Note::findOrFail($noteId);
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }
        $note->delete();

        if ($this->notes->count() <= 1 && $this->page > 1) {
            $this->page--;
        }

        $this->loadNotes();
    }
}
?>

<div class="max-w-xl mx-auto" x-data="{
        format(isoString, type) {
            const date = new Date(isoString);
            if (type === 'time') return date.toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
            const today = new Date();
            today.setHours(0,0,0,0);
            const noteDate = new Date(date);
            noteDate.setHours(0,0,0,0);
            const diffDays = (today - noteDate) / (1000 * 60 * 60 * 24);
            if (diffDays === 0) return 'Today';
            if (diffDays === 1) return 'Yesterday';
            const options = date.getFullYear() === today.getFullYear()
                ? { month: 'long', day: 'numeric' }
                : { month: 'long', day: 'numeric', year: 'numeric' };
            return date.toLocaleDateString([], options);
        }
    }">

    @if ($page === 1)
        <flux:button wire:click="createNote" icon="plus" class="w-full">Add Note</flux:button>
    @endif

    @foreach ($notes as $note)
        <div class="mt-6" wire:key="note-{{ $note->id }}">
            <div class="flex items-center justify-between">
                <flux:heading>
                    @if ($this->shouldShowTime($note))
                        <span x-text="format('{{ $note->created_at->toIso8601String() }}', 'time')">{{ $note->created_at->format('g:i A') }}</span>
                    @else
                        <span x-text="format('{{ $note->created_at->toIso8601String() }}', 'date')">{{ $note->created_at->isToday() ? 'Today' : ($note->created_at->isYesterday() ? 'Yesterday' : ($note->created_at->isCurrentYear() ? $note->created_at->format('F j') : $note->created_at->format('F j, Y'))) }}</span>
                    @endif
                </flux:heading>
                <flux:dropdown align="end">
                    <flux:button variant="subtle" icon="ellipsis-horizontal" icon:variant="micro" size="sm" />
                    <flux:menu>
                        <flux:menu.item icon="trash" icon:variant="micro" variant="danger" wire:click="deleteNote({{ $note->id }})">Delete</flux:menu.item>
                    </flux:menu>
                </flux:dropdown>
            </div>

            <livewire:note :note="$note" :key="$note->id" class="mt-2" />
        </div>
    @endforeach

    @if ($page > 1 || $hasMorePages)
        <flux:separator class="mt-8" variant="subtle" />

        <div class="flex items-center justify-between mt-4">
            <flux:button
                wire:click="previousPage"
                icon="arrow-left"
                variant="subtle"
                :disabled="$page <= 1"
            >
                Previous
            </flux:button>

            <flux:button
                wire:click="nextPage"
                icon-trailing="arrow-right"
                variant="subtle"
                :disabled="!$hasMorePages"
            >
                Next
            </flux:button>
        </div>
    @endif
</div>
