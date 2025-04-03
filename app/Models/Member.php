<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Member extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'role', 'image', 'department_id'];

    // Relationship
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
