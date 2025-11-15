<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use UnitEnum;
use Filament\Actions\Action;
//use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
//use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class SchoolSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    // WAJIB sama tipe-nya dengan parent Page: string|UnitEnum|null
    protected static string|UnitEnum|null $navigationGroup = 'Pengaturan';

    protected static ?string $navigationLabel = 'Pengaturan Sekolah';

    protected static ?string $title = 'Pengaturan Sekolah';

    protected static ?int $navigationSort = 10;

    protected string $view = 'filament.pages.school-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'school_name' => Setting::get('school_name', 'SMK Negeri 1'),
            'school_address' => Setting::get('school_address', 'Jl. Pendidikan No. 123'),
            'school_city' => Setting::get('school_city', 'Jakarta'),
            'school_province' => Setting::get('school_province', 'DKI Jakarta'),
            'school_postal_code' => Setting::get('school_postal_code', '12345'),
            'school_phone' => Setting::get('school_phone', '(021) 1234-5678'),
            'school_email' => Setting::get('school_email', 'ppdb@smk.sch.id'),
            'school_website' => Setting::get('school_website', 'https://smk.sch.id'),
            'school_facebook' => Setting::get('school_facebook', ''),
            'school_instagram' => Setting::get('school_instagram', ''),
            'school_youtube' => Setting::get('school_youtube', ''),
            'school_whatsapp' => Setting::get('school_whatsapp', ''),
            'school_description' => Setting::get(
                'school_description',
                'Sistem Penerimaan Peserta Didik Baru online yang memudahkan calon siswa untuk mendaftar.'
            ),
        ]);
    }

    /**
     * Form instance configuration hook.
     *
     * @param Form $form
     * @return Form
     */
    protected function form(Schema $schema): Schema
    {
        return $schema
            ->components($this->getFormSchema()) // pakai schema komponen
            ->statePath('data');                 // tetap pakai statePath ke $this->data
    }
    /**
     * Define the form schema.
     *
     * @return array
     */
    protected function getFormSchema(): array
    {
        return [
            Section::make('Informasi Umum Sekolah')
                ->description('Data identitas sekolah yang akan ditampilkan di website.')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('school_name')
                                ->label('Nama Sekolah')
                                ->required()
                                ->maxLength(255)
                                ->placeholder('SMK Negeri 1')
                                ->helperText('Nama lengkap sekolah'),

                            TextInput::make('school_email')
                                ->label('Email Sekolah')
                                ->email()
                                ->required()
                                ->maxLength(255)
                                ->placeholder('ppdb@smk.sch.id'),

                            TextInput::make('school_phone')
                                ->label('Nomor Telepon')
                                ->tel()
                                ->required()
                                ->maxLength(20)
                                ->placeholder('(021) 1234-5678'),

                            TextInput::make('school_website')
                                ->label('Website')
                                ->url()
                                ->maxLength(255)
                                ->placeholder('https://smk.sch.id'),
                        ]),

                    Textarea::make('school_description')
                        ->label('Deskripsi Sekolah')
                        ->rows(3)
                        ->maxLength(500)
                        ->placeholder('Deskripsi singkat tentang sekolah')
                        ->helperText('Ditampilkan di footer website (max 500 karakter)'),
                ]),

            Section::make('Alamat Sekolah')
                ->description('Lokasi dan alamat lengkap sekolah.')
                ->schema([
                    Textarea::make('school_address')
                        ->label('Alamat Lengkap')
                        ->required()
                        ->rows(2)
                        ->maxLength(500)
                        ->placeholder('Jl. Pendidikan No. 123'),
                ]),

            Section::make('Media Sosial')
                ->description('Link akun media sosial sekolah.')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('school_facebook')
                                ->label('Facebook')
                                ->url()
                                ->maxLength(255)
                                ->placeholder('https://facebook.com/smk')
                                ->prefixIcon('heroicon-m-globe-alt'),

                            TextInput::make('school_instagram')
                                ->label('Instagram')
                                ->url()
                                ->maxLength(255)
                                ->placeholder('https://instagram.com/smk')
                                ->prefixIcon('heroicon-m-globe-alt'),

                            TextInput::make('school_youtube')
                                ->label('YouTube')
                                ->url()
                                ->maxLength(255)
                                ->placeholder('https://youtube.com/@smk')
                                ->prefixIcon('heroicon-m-globe-alt'),

                            TextInput::make('school_whatsapp')
                                ->label('WhatsApp')
                                ->tel()
                                ->maxLength(20)
                                ->placeholder('628123456789')
                                ->helperText('Format: 628xxx (tanpa tanda +)')
                                ->prefixIcon('heroicon-m-phone'),
                        ]),
                ]),
        ];
    }

    /**
     * Form actions like Save.
     *
     * @return array
     */
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Pengaturan')
                ->icon('heroicon-o-check')
                ->action('save'),
        ];
    }

    /**
     * Save the form data.
     */
    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('Berhasil disimpan!')
            ->success()
            ->body('Pengaturan sekolah telah diperbarui.')
            ->send();
    }
}
