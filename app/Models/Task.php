<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\CarbonInterval;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'human_readable_completion_interval',
        'last_completed',
        'is_complete',
    ];

    public function household(): HasOne
    {
        return $this->hasOne(Household::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(TaskHistory::class)->orderBy('created_at', 'desc');
    }

    public function getHumanReadableCompletionIntervalAttribute(): string
    {
        $interval = CarbonInterval::seconds($this->completion_interval)->cascade();

        return $interval->forHumans([ 'parts' => 1 ]);
    }

    public function getLastCompletedAttribute(): string
    {
        $last_completed = $this->histories()->first();

        if (!$last_completed) {
            return 'Never';
        }

        return Carbon::parse($last_completed->created_at)->diffForHumans(Carbon::now());
    }

    public function getIsCompleteAttribute(): bool
    {
        $last_completed = $this->histories()->first();

        if (!$last_completed) {
            return false;
        }

        $secondsSinceLastCompleted = $last_completed->created_at->diffInSeconds(Carbon::now());

        return $secondsSinceLastCompleted < $this->completion_interval;
    }
}
