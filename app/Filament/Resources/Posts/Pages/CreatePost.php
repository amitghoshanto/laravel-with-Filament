<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use App\Models\Post;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $images = $data['images'];
        unset($data['images']);

        // create post
        $post = Post::create($data);
        $dir = "posts/{$post->id}/";

        $newPaths = [];

        // Move images to the new path
        foreach ($images as $i => $image) {
            $path = $dir.basename($image);
            Storage::disk('public')->move($image, $path);

            $newPaths[] = ['path' => $path, 'sort' => $i];
        }

        // attach images to the post
        $post->images()->createMany($newPaths);

        return $post;
    }
}
