<?php

namespace App\Models;

use App\Models\User;
use App\Models\Household;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HouseholdUser extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function household(): HasOne
    {
        return $this->hasOne(Household::class);
    }
}
