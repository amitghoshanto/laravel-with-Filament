<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->columnSpanFull(),

                FileUpload::make('images')
                    ->multiple()
                    ->deletable()
                    ->panelLayout('grid')
                    ->disk('public')
                    ->directory('posts')
                    ->columnSpanFull()
                    ->reorderable(),
            ]);
    }
}
