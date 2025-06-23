<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Department extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'description', 'image'];

    // Relationship
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function works(): HasMany
    {
        return $this->hasMany(Work::class);
    }
}
