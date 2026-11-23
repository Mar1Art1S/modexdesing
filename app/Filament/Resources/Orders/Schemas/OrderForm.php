<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Enums\OrderStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('service_type'),
                TextInput::make('material'),
                TextInput::make('quantity'),
                Textarea::make('details')
                    ->columnSpanFull(),
                Textarea::make('files')
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(OrderStatus::class)
                    ->default('new')
                    ->required(),
                TextInput::make('estimated_price')
                    ->numeric()
                    ->prefix('$'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
