<?php

namespace App\Models\Traits;

trait HasImages
{
    protected array $imagesPath = [];

    public function getImagesAttribute(): array
    {
        return $this->images()->pluck('path')->toArray();
    }

    public function setImagesAttribute(array $paths): void
    {
        $this->imagesPath = array_map(fn($path) => ['path' => $path], $paths);
    }

    protected static function bootHasImages(): void
    {
        static::created(function (self $model) {
            $model->images()->createMany($model->imagesPath);
        });

        static::updated(function (self $model) {
            // dd($model->imagesPath);
            $model->images()->delete();
            $model->images()->createMany($model->imagesPath);
        });
    }
}
