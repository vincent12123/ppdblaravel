<?php

namespace App\Filament\Pages;

use App\Http\Controllers\ChatbotController;
use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ChatbotSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static UnitEnum|string|null $navigationGroup = 'Pengaturan';

    protected static ?string $title = 'Pengaturan Chatbot (Gemini)';

    protected static ?int $navigationSort = 55;

    public bool $gemini_enabled = false;
    public ?string $gemini_api_key = null;
    public ?string $gemini_model = 'gemini-1.5-flash';
    public ?string $gemini_system_instruction = null;

    public function mount(): void
    {
        $this->gemini_enabled = Setting::get('gemini_enabled', 'false') === 'true';
        $this->gemini_api_key = Setting::get('gemini_api_key');
        $this->gemini_model = Setting::get('gemini_model', 'gemini-1.5-flash');
        $this->gemini_system_instruction = Setting::get('gemini_system_instruction', ChatbotController::defaultSystemInstruction());
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Status & API Key')
                ->schema([
                    Toggle::make('gemini_enabled')->label('Aktifkan Chatbot')->inline(false),
                    TextInput::make('gemini_api_key')->label('Gemini API Key')->password()->revealable()->helperText('Kunci API dari Google AI Studio'),
                ])->columns(2),
            Section::make('Model & Perilaku')
                ->schema([
                    Select::make('gemini_model')->label('Model')->options([
                        'gemini-1.5-flash' => 'gemini-1.5-flash (cepat)',
                        'gemini-1.5-pro' => 'gemini-1.5-pro (lebih akurat)',
                    ])->searchable(),
                    Textarea::make('gemini_system_instruction')->label('Instruksi Sistem')->rows(6)->helperText('Batasi jawaban sesuai konteks PPDB.'),
                ])->columns(1),
        ];
    }

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
        ];
    }

    public function save(): void
    {
        Setting::set('gemini_enabled', $this->gemini_enabled ? 'true' : 'false');
        Setting::set('gemini_api_key', $this->gemini_api_key);
        Setting::set('gemini_model', $this->gemini_model);
        Setting::set('gemini_system_instruction', $this->gemini_system_instruction);

        Notification::make()->title('Pengaturan chatbot tersimpan')->success()->send();
    }
}
