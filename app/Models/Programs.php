<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Programs extends Model
{
    use HasUuids;

    protected $fillable = ['title', 'desc', 'image', 'category_id', 'instagram'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
