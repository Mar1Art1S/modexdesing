<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Enums\ProjectCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title_ua')
                    ->required(),
                TextInput::make('title_en')
                    ->required(),
                Select::make('category')
                    ->options(ProjectCategory::class)
                    ->default('architecture')
                    ->required(),
                Textarea::make('description_ua')
                    ->columnSpanFull(),
                Textarea::make('description_en')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image(),
                Textarea::make('gallery')
                    ->columnSpanFull(),
                TextInput::make('order_column')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
