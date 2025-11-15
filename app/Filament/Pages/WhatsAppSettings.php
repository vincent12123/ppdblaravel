<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Services\FonnteClient;
// Import individual components: layout `Section` now lives under Schemas in Filament v4
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;

class WhatsAppSettings extends Page
{
    // Must match parent signature: string | BackedEnum | null
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    // Use default Filament page view; render form via schema components in content().
    // Must match parent signature: UnitEnum|string|null
    protected static string|\UnitEnum|null $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 50;
    protected static ?string $title = 'Pengaturan WhatsApp (Fonnte)';

    public bool $fonnte_enabled = false;
    public ?string $fonnte_token = null;
    public ?string $fonnte_template_registered = null;
    public ?string $fonnte_template_accepted = null;
    public ?string $fonnte_template_rejected = null;
    public ?string $test_phone = null;
    public ?string $test_template = 'registered';

    public function mount(): void
    {
    $this->fonnte_enabled = Setting::get('fonnte_enabled', 'false') === 'true';
        $this->fonnte_token = Setting::get('fonnte_token');
        $this->fonnte_template_registered = Setting::get('fonnte_template_registered') ?? config('fonnte.templates.registered');
        $this->fonnte_template_accepted = Setting::get('fonnte_template_accepted') ?? config('fonnte.templates.accepted');
        $this->fonnte_template_rejected = Setting::get('fonnte_template_rejected') ?? config('fonnte.templates.rejected');
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Status & Token')
                ->schema([
                    Toggle::make('fonnte_enabled')
                        ->label('Aktifkan Integrasi Fonnte')
                        ->inline(false),
                    TextInput::make('fonnte_token')
                        ->password()
                        ->revealable()
                        ->label('API Token')
                        ->helperText('Masukkan token API dari dashboard Fonnte.'),
                ])->columns(2),
            Section::make('Template Pesan')
                ->schema([
                    Textarea::make('fonnte_template_registered')
                        ->label('Template Pendaftaran Berhasil')
                        ->rows(3)
                        ->helperText('Placeholder: {name} {reg}'),
                    Textarea::make('fonnte_template_accepted')
                        ->label('Template Diterima')
                        ->rows(3)
                        ->helperText('Placeholder: {name} {reg} {major}'),
                    Textarea::make('fonnte_template_rejected')
                        ->label('Template Ditolak')
                        ->rows(3)
                        ->helperText('Placeholder: {name} {reg}'),
                ])->columns(3),
            Section::make('Uji Kirim')
                ->schema([
                    TextInput::make('test_phone')
                        ->label('Nomor HP Uji (contoh: 081234567890)')
                        ->tel(),
                    Select::make('test_template')
                        ->label('Pilih Template')
                        ->options([
                            'registered' => 'Pendaftaran Berhasil',
                            'accepted' => 'Diterima',
                            'rejected' => 'Ditolak',
                        ])->default('registered'),
                ])->columns(3),
        ];
    }

    // Render form sections inside page content schema.
    public function content(Schema $schema): Schema
    {
        return $schema->components($this->getFormSchema());
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Pengaturan')
                ->icon('heroicon-o-check-circle')
                ->color('primary')
                ->action(fn () => $this->save()),
            Action::make('sendTestMessage')
                ->label('Kirim Pesan Uji')
                ->icon('heroicon-o-paper-airplane')
                ->color('success')
                ->action(fn () => $this->sendTestMessage())
                ->disabled(fn (): bool => blank($this->test_phone) || blank($this->fonnte_token) || ! $this->fonnte_enabled),
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

        $templateKey = $this->test_template ?? 'registered';
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
