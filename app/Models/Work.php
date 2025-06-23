<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Work extends Model
{
    use HasUuids;

    protected $fillable = ['name', 'description', 'image', 'department_id'];

    // Relationship
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }
}
