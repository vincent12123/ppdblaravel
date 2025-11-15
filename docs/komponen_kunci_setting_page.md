Tentu, rekan programmer! Karena kita berfokus pada pembangunan dan pengelolaan antarmuka admin yang efisien di **Filament 4 (v4.x)**, pemilihan komponen yang tepat untuk *Settings Page* sangat penting. *Settings Page* biasanya merupakan *Custom Page* atau *Single Resource* yang tidak terikat langsung pada tabel, melainkan pada satu baris konfigurasi atau file JSON.

Berikut adalah panduan lengkap mengenai komponen yang cocok dan cara implementasinya di Filament 4 untuk dashboard PPDB Anda:

---

## Komponen Kunci untuk Settings Page di Filament 4

Settings Page yang baik harus memiliki struktur yang jelas, memisahkan grup konfigurasi, dan mendukung input data yang beragam (Boolean, teks, angka, dll.).

### 1. Struktur dan Pengelompokan (Layout)

Untuk mengatur tata letak formulir pengaturan yang besar, di Filament 4, Anda harus menggunakan komponen struktural dari *namespace* **`Filament\Schemas\Components`**.

| Komponen | Namespace | Kegunaan dalam Settings Page | Catatan Kunci di Filament 4 |
| :--- | :--- | :--- | :--- |
| **`Section`** | `Filament\Schemas\Components\Section` | Mengelompokkan input fields secara visual di bawah judul. Ideal untuk memisahkan "General Settings", "WhatsApp Settings", dan "Integrasi API". | *Section* sangat kuat karena dapat memiliki aksi kaki (*footer actions*) yang terpisah untuk menyimpan bagian formulir tersebut secara mandiri (`saveFormComponentOnly()`). |
| **`Tabs`** | `Filament\Schemas\Components\Tabs` | Mengorganisir banyak grup pengaturan ke dalam tab yang dapat diakses secara cepat. | Jika Anda menggunakan *Custom Page*, Anda bisa menggunakan *sub-navigation* di posisi atas (`SubNavigationPosition::Top`) untuk meniru tampilan tab pengaturan modern. |
| **`Grid`** | `Filament\Schemas\Components\Grid` | Mengatur komponen input di dalam `Section` agar muncul dalam beberapa kolom (misalnya 2 atau 3 kolom), memastikan penggunaan ruang yang efisien. | Jika Anda menggunakan `QueryBuilder` di filter, Anda juga dapat mengontrol kolom grid secara responsif. |

### Contoh Kode Struktur (Menggunakan `Section`):

```php
// app/Filament/Pages/GeneralSettings.php (Custom Page)
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

protected function getFormSchema(): array
{
    return [
        Section::make('Pengaturan Waktu PPDB')
            ->description('Mengontrol tanggal buka dan tutup pendaftaran.')
            ->schema([
                Forms\Components\DateTimePicker::make('start_date'),
                Forms\Components\DateTimePicker::make('end_date'),
            ]),
            
        Section::make('Notifikasi WhatsApp')
            ->description('Konfigurasi token dan status layanan WA Gateway.')
            ->schema([
                TextInput::make('wa_token')
                    ->label('Token API')
                    ->password()
                    ->maxLength(255),
                
                Toggle::make('is_wa_active') // Interaksi boolean
                    ->label('Aktifkan Layanan WhatsApp')
                    ->helperText('Matikan ini untuk menonaktifkan semua notifikasi WA.')
            ]),
    ];
}
```

### 2. Komponen Input Fungsional (Data Fields)

Untuk mengumpulkan nilai konfigurasi, Anda akan menggunakan komponen dari *namespace* **`Filament\Forms\Components`**.

| Komponen Input | Deskripsi / Penggunaan dalam Settings PPDB | Catatan Kunci Filament 4 |
| :--- | :--- | :--- |
| **`TextInput`** | Untuk input string atau numerik (misalnya, nama aplikasi, nomor telepon admin, batas kuota pendaftar). | Dapat dikonfigurasi dengan `numeric()` untuk membatasi input hanya ke angka, atau `password()` untuk token API. |
| **`Toggle`** | Memungkinkan interaksi nilai Boolean (on/off). Sempurna untuk mengaktifkan/menonaktifkan fitur (misalnya, `maintenance_mode`, `is_registration_open`). | Mirip dengan `Checkbox`. Anda dapat mengkonfigurasinya secara global menggunakan `configureUsing()` jika perlu mengubah perilaku default. |
| **`RichEditor`** | Jika Settings Page mencakup konten seperti "Syarat dan Ketentuan" atau "Pengumuman Resmi PPDB". | Menawarkan banyak fitur *toolbar* termasuk daftar, *highlight*, tabel, dan bahkan blok kustom. |
| **`CheckboxList`** | Berguna untuk memilih beberapa opsi dari daftar statis (misalnya, memilih jalur pendaftaran mana yang aktif: Zonasi, Afirmasi, Prestasi). | Mendukung `selectAllAction()` dan `deselectAllAction()` untuk manajemen opsi yang mudah. |
| **`Slider`** | Untuk memilih nilai numerik dalam rentang tertentu (misalnya, mengatur persentase kuota afirmasi, 0-100). | Slider tidak bisa memiliki nilai kosong (`null`), jadi ia akan memiliki nilai *default*. Anda dapat mengatur perilaku geser (`Behavior::Drag`, `Behavior::Tap`). |
| **`FileUpload`** | Mengunggah logo sekolah, atau *template* dokumen resmi. | Dapat membatasi tipe file (`acceptedFileTypes`) dan ukuran file. |

### 3. Implementasi Aksi Lanjutan (Actions)

Settings Page seringkali memerlukan aksi khusus selain penyimpanan standar, terutama jika bagian form terpisah harus disimpan secara independen.

#### Aksi Penyimpanan Independent (Save Part of Form)

Anda dapat memungkinkan pengguna menyimpan hanya sebagian formulir (misalnya, hanya bagian notifikasi) tanpa memvalidasi atau menyimpan bagian lain.

```php
// Contoh menyimpan hanya bagian "Rate limiting"
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Section;

// ... dalam metode form() atau getFormSchema() ...

Section::make('Rate Limiting Settings')
    ->schema([
        // ... komponen input untuk rate limiting ...
    ])
    ->footerActions([
        fn (string $operation): Action => Action::make('save_rate_limit')
            ->label('Simpan Pengaturan Batas')
            ->action(function (Section $component, EditRecord $livewire) {
                // Hanya simpan komponen Section ini
                $livewire->saveFormComponentOnly($component);
                
                Notification::make()
                    ->title('Pengaturan disimpan')
                    ->success()
                    ->send();
            })
            ->visible($operation === 'edit'), // Aksi ini hanya terlihat di halaman Edit
    ])
```

#### Aksi Trigger Cepat

Anda juga dapat menambahkan tombol aksi yang memicu proses di luar penyimpanan form, seperti tombol "Kirim Uji Coba Notifikasi WA".

```php
use Filament\Actions\Action;
use Filament\Notifications\Notification;

Action::make('send_test_wa')
    ->label('Kirim Uji Coba WA')
    ->icon('heroicon-o-chat-bubble-left')
    ->color('secondary')
    ->modalHeading('Kirim Pesan Uji Coba') // Membuka modal konfirmasi
    ->schema([
        // Input form di dalam modal (misal: nomor tujuan uji coba)
        Forms\Components\TextInput::make('test_number')->required(),
    ])
    ->action(function (array $data) {
        // Logika untuk memicu pengiriman notifikasi WA
        // ...
        
        Notification::make()
            ->title('Pesan Uji Coba Terkirim!')
            ->success()
            ->send();
    })
```

Filament 4 (v4.1) menawarkan fondasi yang kokoh, di mana semua *user interface* didefinisikan secara deklaratif di PHP. Ini akan sangat membantu Anda dalam menjaga konsistensi dan efisiensi di seluruh panel admin PPDB.
