<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function household(): HasOne
    {
        return $this->hasOne(Household::class);
    }

    public function history(): HasMany
    {
        return $this->hasMany(TaskHistory::class);
    }
}
