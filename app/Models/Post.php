<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $fillable = [
        'title',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class, 'post_id')->orderBy('sort', 'asc');
    }
}
