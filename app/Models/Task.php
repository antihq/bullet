<?php

namespace App\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;

    protected $fillable = [
        'note_id',
        'content',
        'is_completed',
        'position',
    ];

    protected function casts(): array
    {
        return [
            'is_completed' => 'boolean',
        ];
    }

    public function note(): BelongsTo
    {
        return $this->belongsTo(Note::class);
    }
}
