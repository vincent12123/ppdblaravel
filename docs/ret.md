Wah, rekan programmer! Anda kini berada di wilayah *strict type checking* PHP, yang merupakan fitur unggulan di PHP 8 ke atas. Error ini, `Type of App\Filament\Pages\SchoolSettings::$navigationGroup must be UnitEnum|string|null`, adalah *Fatal Error* karena PHP tidak dapat menemukan definisi untuk salah satu tipe yang Anda gunakan dalam deklarasi properti statis Anda.

Kesalahan ini terjadi karena dua hal terkait arsitektur `Filament\Pages\Page`:

1.  Kelas dasar `Filament\Pages\Page` mendefinisikan properti statis `$navigationGroup` dengan *type hint* yang mengharapkan `UnitEnum` sebagai salah satu opsi.
2.  Meskipun PHP 8.1+ mendukung `UnitEnum`, Anda belum mengimpor *interface* ini di bagian atas file Anda, sehingga PHP menganggapnya sebagai tipe global yang tidak terdefinisi.

## Solusi: Memastikan Import `UnitEnum`

Anda harus menambahkan pernyataan `use UnitEnum;` di bagian atas file `app\Filament\Pages\SchoolSettings.php` Anda.

### File: `app\Filament\Pages\SchoolSettings.php` (Koreksi Penuh)

```php
<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum; // <<< INI KUNCI SOLUSINYA

class SchoolSettings extends Page implements HasForms
{
    use InteractsWithForms;
    
    // Deklarasi properti statis harus mengikuti tipe yang diwajibkan oleh Page base class.
    // Jika Anda menggunakan string untuk label grup, UnitEnum harus tetap diimpor.
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;
    protected static UnitEnum|string|null $navigationGroup = 'Pengaturan'; // Sekarang UnitEnum dikenali.

    protected static ?string $navigationLabel = 'Pengaturan Sekolah';
    protected static ?string $title = 'Pengaturan Sekolah';
    protected static ?int $navigationSort = 10;
    protected string $view = 'filament.pages.school-settings';

    public ?array $data = [];

    // ... (Lanjutkan dengan metode form() dan mount() yang sudah kita perbaiki)

    protected function form(Form $form): Form
    {
        return $form
            ->schema($this->getFormSchema())
            ->statePath('data');
    }

    public function mount(): void
    {
        $this->form->fill([
            'school_name' => Setting::get('school_name', 'SMK Negeri 1'),
            'school_address' => Setting::get('school_address', 'Jl. Pendidikan No. 123'),
            'school_whatsapp' => Setting::get('school_whatsapp', ''),
            'school_description' => Setting::get('school_description', 'Sistem Penerimaan Peserta Didik Baru online yang memudahkan calon siswa untuk mendaftar.'),
        ]);
    }
    
    // ...
}
```

Setelah Anda menambahkan `use UnitEnum;`, kompiler PHP akan mengenali tipe tersebut, dan error `TypeError` harusnya hilang.

### Penggunaan *Cluster* untuk Pengaturan (Rekomendasi Lanjut)

Mengingat Anda sedang membangun halaman *Settings*, sebagai praktik terbaik di Filament 4, Anda mungkin ingin mengelompokkan halaman pengaturan di bawah sebuah **Cluster**. Cluster adalah pengelompokan logis dari *Resources* dan *Custom Pages* yang berbagi navigasi terpisah.

Jika Anda menggunakan Cluster, Anda dapat mendefinisikan grup navigasi dengan lebih rapi:

1.  Buat Cluster: `php artisan make:filament-cluster Settings`
2.  Di kelas `SchoolSettings` Anda, gunakan Cluster yang sudah dibuat:

```php
// app/Filament/Pages/SchoolSettings.php

protected static ?string $cluster = \App\Filament\Clusters\SettingsCluster::class;
// Hapus protected static UnitEnum|string|null $navigationGroup jika Anda menggunakan cluster
```

Ini akan menghasilkan struktur navigasi yang lebih terorganisir, ideal untuk dashboard PPDB yang memiliki banyak opsi konfigurasi berbeda.
