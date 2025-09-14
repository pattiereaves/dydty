<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'human_readable_completion_interval',
        'last_completed',
        'is_complete',
        'last_completed_by',
    ];

    public function household(): BelongsTo
    {
        return $this->belongsTo(Household::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(TaskHistory::class)->orderBy('created_at', 'desc');
    }

    public function getHumanReadableCompletionIntervalAttribute(): string
    {
        $interval = CarbonInterval::seconds($this->completion_interval)->cascade();

        return $interval->forHumans(['parts' => 1]);
    }

    public function getLastCompletedAttribute(): string
    {
        $last_completed = $this->histories()->first();

        if (! $last_completed) {
            return 'Never';
        }

        return Carbon::parse($last_completed->created_at)->diffForHumans(Carbon::now());
    }

    public function getIsCompleteAttribute(): bool
    {
        $last_completed = $this->histories()->first();

        if (! $last_completed) {
            return false;
        }

        $secondsSinceLastCompleted = $last_completed->created_at->diffInSeconds(Carbon::now());

        return $secondsSinceLastCompleted < $this->completion_interval;
    }

    public function getLastCompletedByAttribute(): string
    {
        $last_completed = $this->histories()->first();

        if (! $last_completed) {
            return '';
        }

        return $last_completed->user->name ?: $last_completed->user->email;
    }
}
