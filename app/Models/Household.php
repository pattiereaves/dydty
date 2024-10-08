<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Household extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->orderBy('completion_interval', 'asc');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('invitation_pending');
    }
}
