<?php

namespace App\Models;

use App\Models\Traits\HasImages;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasImages;
    protected $fillable = [
        'title',

    ];

    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class, 'post_id');
    }
}
