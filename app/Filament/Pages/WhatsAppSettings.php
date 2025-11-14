<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Services\FonnteClient;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class WhatsAppSettings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static string $view = 'filament.pages.whatsapp-settings';
    // Must match parent signature: UnitEnum|string|null
    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 50;
    protected static ?string $title = 'Pengaturan WhatsApp (Fonnte)';

    public ?string $fonnte_enabled = null;
    public ?string $fonnte_token = null;
    public ?string $fonnte_template_registered = null;
    public ?string $fonnte_template_accepted = null;
    public ?string $fonnte_template_rejected = null;
    public ?string $test_phone = null;

    public function mount(): void
    {
        $this->fonnte_enabled = Setting::get('fonnte_enabled', 'false');
        $this->fonnte_token = Setting::get('fonnte_token');
        $this->fonnte_template_registered = Setting::get('fonnte_template_registered') ?? config('fonnte.templates.registered');
        $this->fonnte_template_accepted = Setting::get('fonnte_template_accepted') ?? config('fonnte.templates.accepted');
        $this->fonnte_template_rejected = Setting::get('fonnte_template_rejected') ?? config('fonnte.templates.rejected');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Status & Token')
                ->schema([
                    Forms\Components\Toggle::make('fonnte_enabled')
                        ->label('Aktifkan Integrasi Fonnte')
                        ->inline(false),
                    Forms\Components\TextInput::make('fonnte_token')
                        ->password()
                        ->revealable()
                        ->label('API Token')
                        ->helperText('Masukkan token API dari dashboard Fonnte.'),
                ])->columns(2),
            Forms\Components\Section::make('Template Pesan')
                ->schema([
                    Forms\Components\Textarea::make('fonnte_template_registered')
                        ->label('Template Pendaftaran Berhasil')
                        ->rows(3)
                        ->helperText('Placeholder: {name} {reg}'),
                    Forms\Components\Textarea::make('fonnte_template_accepted')
                        ->label('Template Diterima')
                        ->rows(3)
                        ->helperText('Placeholder: {name} {reg} {major}'),
                    Forms\Components\Textarea::make('fonnte_template_rejected')
                        ->label('Template Ditolak')
                        ->rows(3)
                        ->helperText('Placeholder: {name} {reg}'),
                ])->columns(3),
            Forms\Components\Section::make('Uji Kirim')
                ->schema([
                    Forms\Components\TextInput::make('test_phone')
                        ->label('Nomor HP Uji (contoh: 081234567890)')
                        ->tel(),
                    Forms\Components\Select::make('test_template')
                        ->label('Pilih Template')
                        ->options([
                            'registered' => 'Pendaftaran Berhasil',
                            'accepted' => 'Diterima',
                            'rejected' => 'Ditolak',
                        ])->default('registered'),
                    Forms\Components\Button::make('Kirim Pesan Uji')
                        ->action('sendTestMessage')
                        ->color('success')
                        ->icon('heroicon-o-paper-airplane'),
                ])->columns(3),
        ];
    }

    public function save(): void
    {
        Setting::set('fonnte_enabled', $this->fonnte_enabled ? 'true' : 'false');
        Setting::set('fonnte_token', $this->fonnte_token);
        Setting::set('fonnte_template_registered', $this->fonnte_template_registered);
        Setting::set('fonnte_template_accepted', $this->fonnte_template_accepted);
        Setting::set('fonnte_template_rejected', $this->fonnte_template_rejected);

        Notification::make()->title('Pengaturan tersimpan')->success()->send();
    }

    public function sendTestMessage(): void
    {
        $client = new FonnteClient();
        if (! $client->enabled()) {
            Notification::make()->title('Fonnte belum diaktifkan atau token kosong')->danger()->send();
            return;
        }
        if (empty($this->test_phone)) {
            Notification::make()->title('Nomor uji kosong')->danger()->send();
            return;
        }

        $templateKey = request()->input('test_template', 'registered');
        $message = $client->renderTemplate($templateKey, [
            'name' => 'Tes User',
            'reg' => 'TEST-000',
            'major' => 'Jurusan Contoh',
        ]);

        $result = $client->send($this->test_phone, $message);

        if ($result['success']) {
            Notification::make()->title('Pesan uji terkirim')->success()->send();
        } else {
            Notification::make()->title('Gagal kirim: ' . $result['error'])->danger()->send();
        }
    }
}
