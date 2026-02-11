<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Badge extends Model
{
    protected $fillable = ['name', 'description', 'points_required', 'cashback_amount'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'current_badge_id');
    }
}
