<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Filament\Resources\SettingResource\RelationManagers;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->label('Setting Key')
                    ->required()
                    ->disabled(fn($record) => $record !== null), // Prevent editing existing keys

                Forms\Components\TextInput::make('value')
                    ->label('Setting Value')
                    ->visible(fn($record) => $record === null || !in_array($record->key, ['voting_deadline', 'seo_description', 'seo_title'])),

                Forms\Components\DateTimePicker::make('value')
                    ->label('Voting Deadline')
                    ->required()
                    ->visible(fn($record) => $record && $record->key === 'voting_deadline'),

                Forms\Components\TextInput::make('value')
                    ->label('SEO Meta Title')
                    ->required()
                    ->visible(fn($record) => $record && $record->key === 'seo_title'),

                Forms\Components\Textarea::make('value')
                    ->label('SEO Meta Description')
                    ->rows(3)
                    ->visible(fn($record) => $record && $record->key === 'seo_description'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('key')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('value')->limit(50)->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->label('Last Updated')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
