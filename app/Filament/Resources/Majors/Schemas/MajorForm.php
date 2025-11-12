<?php

namespace App\Filament\Resources\Majors\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;
use App\Models\Major;

class MajorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dasar Jurusan')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(debounce: 500) // Memastikan slug terupdate secara real-time
                            ->afterStateUpdated(fn (string $operation, $state, Set $set) => $set('slug', Str::slug($state))) // [7]

                        ,
                        TextInput::make('slug')
                            ->disabled() // Tidak bisa diedit manual [8]
                            ->required()
                            ->maxLength(255)
                            ->unique(Major::class, 'slug', ignoreRecord: true),

                        TextInput::make('quota')
                            ->label('Kuota Penerimaan (Angka)')
                            ->required()
                            ->integer() // Hanya menerima input angka [9]
                            ->placeholder('Contoh: 120'),

                        FileUpload::make('icon')
                            ->label('Icon Jurusan/Logo')
                            ->image()
                            ->imageEditor() // Memungkinkan cropping gambar [10]
                            ->imageEditorAspectRatios([
                                '1:1', // Rasio persegi untuk icon [11]
                            ])
                            ->disk('public') // Simpan di disk public
                            ->directory('major-icons') // Sub-folder khusus [12]
                            ->columnSpanFull(),

                    ])->columns(2),

                Section::make('Deskripsi Detail')
                    ->schema([
                        // Menggunakan RichEditor atau MarkdownEditor untuk konten kaya [13, 14]
                        MarkdownEditor::make('description')
                            ->label('Deskripsi Singkat/Profil Jurusan')
                            ->required()
                            ->columnSpanFull(),

                        RichEditor::make('facilities')
                            ->label('Fasilitas Pendukung')
                            ->fileAttachmentsDisk('public') // Konfigurasi upload gambar di editor [15]
                            ->columnSpanFull(),

                        RichEditor::make('career_prospects')
                            ->label('Prospek Karir Lulusan')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
