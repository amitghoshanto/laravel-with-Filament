<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    $images = collect([
        'posts/1/1.jpg',
        'posts/1/2.jpg',
        'posts/1/new-3.jpg',
        'posts/1/4.jpg',
    ])->pluck('path')->toArray();

    $imagesWithSort = [
        ['path' => 'posts/1/1.jpg', 'sort' => 0],
        ['path' => 'posts/1/2.jpg', 'sort' => 1],
        ['path' => 'posts/1/new-3.jpg', 'sort' => 2],
        ['path' => 'posts/1/4.jpg', 'sort' => 3],
    ];

    $oldImages = [
        ['path' => 'posts/1/1.jpg', 'sort' => 0],
        ['path' => 'posts/1/2.jpg', 'sort' => 1],
        ['path' => 'posts/1/3.jpg', 'sort' => 2],
        ['path' => 'posts/1/4.jpg', 'sort' => 3],
    ];

    $removedImages = array_diff($oldImages, $imagesWithSort);
    dd($removedImages);

});
