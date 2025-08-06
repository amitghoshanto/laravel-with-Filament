<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PostImage extends Model
{
    protected $fillable = [
        'post_id',
        'path'
    ];
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    protected static function booted(): void
    {
        static::deleted(function (self $postImage) {
            //dd('deleted');
            if (Storage::exists($postImage->path)) {
                Storage::delete($postImage->path);
            }
        });
    }
}
