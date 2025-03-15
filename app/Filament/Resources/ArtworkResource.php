<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArtworkResource\Pages;
use App\Filament\Resources\ArtworkResource\RelationManagers;
use App\Models\Artwork;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\RichEditor;
use Str;



class ArtworkResource extends Resource
{
    protected static ?string $model = Artwork::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->label('Judul Karya')->required()->unique(ignoreRecord: true)->columnSpanFull(),
                Forms\Components\TextInput::make('author')->label('Pemilik Karya')->required()->columnSpanFull(),
                Forms\Components\Select::make('category')
                    ->label('Kategori')
                    ->helperText('Pilih kategori karya Anda')
                    ->options([
                        'goresan' => 'Goresan',
                        'ekspresi' => 'Ekspresi',
                        'larik' => 'Larik',
                    ])
                    ->required()->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->label('Gambar Karya')
                    ->disk('public') 
                    ->directory('artworks')
                    ->acceptedFileTypes(['image/jpeg', 'image/jpg'])
                    ->required()->columnSpanFull(),
                RichEditor::make('description')
                    ->nullable()
                    ->label('Deskripsi Karya')
                    ->helperText('Tuliskan makna dari karya Anda.')
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'underline',
                        'strike',
                        'h2',
                        'h3',
                        'bulletList',
                        'orderedList',
                        'blockquote',
                        'redo',
                        'undo',
                    ])
                    ->afterStateUpdated(
                        fn($state, callable $set) =>
                        $set('featured_description', Str::limit(strip_tags($state), 200))
                    )
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('featured_description')
                    ->label('Deskripsi Unggulan')
                    ->helperText('Deskripsi yang akan ditampilkan di halaman utama')
                    ->maxLength(200)
                    ->disabled()
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('title')->label('Judul Karya'),
                Tables\Columns\ImageColumn::make('image')->label('Gambar Karya')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('featured_description')->limit(50),
                Tables\Columns\TextColumn::make('author')->label('Pemilik Karya'),
                Tables\Columns\TextColumn::make('category')->label('Kategori'),
            ])
            ->filters([
                //
                Tables\Filters\TrashedFilter::make(), 
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\RestoreAction::make(), 
            Tables\Actions\ForceDeleteAction::make(), 
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(), 
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
            'index' => Pages\ListArtworks::route('/'),
            'create' => Pages\CreateArtwork::route('/create'),
            'edit' => Pages\EditArtwork::route('/{record}/edit'),
        ];
    }
}
