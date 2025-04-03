<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Department extends Model
{
    use HasUuids;

    protected $fillable = ['name'];

    // Relationship
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }
}
