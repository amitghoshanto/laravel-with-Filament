<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $images = collect($data['images'])
            ->map(fn ($image, $i) => [
                'path' => $image,
                'sort' => $i,
            ]);

        unset($data['images']);

        // old images from database
        $oldImages = $record->images()->get(['path', 'sort']);

        $newPaths = $images->pluck('path');
        $oldPaths = $oldImages->pluck('path');

        // Determine removed and added
        $removedImages = $oldImages->reject(fn ($img) => $newPaths->contains($img['path']))->values();
        $addedImages = $images->reject(fn ($img) => $oldPaths->contains($img['path']))->values();

        // Delete removed images
        if ($removedImages->isNotEmpty()) {
            $record->images()->whereIn('path', $removedImages->pluck('path'))->delete();
            $removedImages->each(function ($img) {
                Storage::disk('public')->delete($img['path']);
            });
        }

        // Add new images
        if ($addedImages->isNotEmpty()) {
            $record->images()->createMany($addedImages);
        }

        // Update sort for existing images that remain
        $existingImagesToUpdate = $images->whereIn('path', $oldPaths->diff($removedImages->pluck('path')));

        $existingImagesToUpdate->each(function ($img) use ($record) {
            $record->images()
                ->where('path', $img['path'])
                ->update(['sort' => $img['sort']]);
        });

        return $record;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['images'] = $this->record->images->sortBy('sort')->pluck('path')->toArray();

        return $data;
    }
}
