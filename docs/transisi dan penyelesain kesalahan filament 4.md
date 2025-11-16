Keputusan Anda untuk memahami perbedaan arsitektur antara Filament v3 dan v4 secara mendalam adalah kunci keberhasilan dalam membangun dan mengelola antarmuka admin yang efisien di Laravel! Saya akan memberikan rekapitulasi yang sangat rinci mengenai transisi ini, yang didasarkan pada pengalaman *error* Anda dan dokumentasi Filament v4.1 yang tersedia.

## I. Fondasi Arsitektur Kritis Filament v4

Perbedaan paling mendasar adalah adopsi penuh arsitektur **Server-Driven UI (SDUI)**, di mana antarmuka didefinisikan secara murni menggunakan objek konfigurasi PHP.

### 1. Perubahan Namespacing Kritis (`use ...`)

Ini adalah sumber *error* yang paling sering Anda alami. Di v4.x, komponen dibagi berdasarkan fungsi:

| Kategori Komponen | Namespacing yang Diduga (v3.x) | Namespacing WAJIB di Filament v4.x | Catatan Kunci | Sumber |
| :--- | :--- | :--- | :--- | :--- |
| **Komponen Struktural/Layout** | `Filament\Forms\Components\Section` | **`Filament\Schemas\Components\Section`** | Semua komponen struktural yang mendefinisikan *layout* (bukan input data) pindah ke `Schemas`. | |
| **Komponen Layout Lain** | `Filament\Forms\Components\Grid` | **`Filament\Schemas\Components\Grid`** | Komponen layout kolom. | |
| **Komponen Layout Terpadu** | N/A | **`Filament\Schemas\Components\FusedGroup`** | Digunakan untuk menggabungkan field agar terlihat menyatu. | |
| **Komponen Input Data (Fields)** | `Filament\Forms\Components\TextInput` | **`Filament\Forms\Components\TextInput`** | Input fields tetap berada di *namespace* `Forms\Components`. |

### 2. Pengetatan Tipe (Type Hinting)

*Fatal Error* yang terkait dengan `UnitEnum` disebabkan karena Filament 4 mengharuskan PHP 8.2+ dan penggunaan *type hint* yang ketat.

*   **Masalah:** Error `Type of ...::$navigationGroup must be UnitEnum|string|null`.
*   **Solusi:** Tipe `UnitEnum` harus diimpor secara eksplisit: `use UnitEnum;`.

## II. Perbedaan Fungsionalitas dan Fitur Utama

### 1. Dinamisme dan Reaktivitas

Di v4.x, Field dan komponen UI menjadi sangat dinamis berkat **Utility Injection**. Metode konfigurasi (seperti `options()`, `hidden()`, `maxSize()`, `blockPickerWidth()`) menerima *closure* yang dapat menyuntikkan utilitas penting:

| Utility | Kegunaan | Sumber |
| :--- | :--- | :--- |
| **`$get`** | Mengambil nilai dari field lain dalam formulir saat ini untuk reaktivitas UI. | |
| **`$record`** | Mengakses *Eloquent record* yang sedang diolah (tersedia di halaman Edit/View). | |
| **`$operation`** | Mengidentifikasi operasi saat ini (`create`, `edit`, atau `view`). | |
| **`$livewire`** | *Instance* komponen Livewire. | |

### 2. Manajemen Data Kompleks

| Fitur | Pendekatan v3 (Klasik) | Pendekatan v4.x (Tersentralisasi) | Sumber |
| :--- | :--- | :--- | :--- |
| **Data Struktur Berulang** | Umumnya menggunakan `Repeater` untuk skema tunggal yang diulang. | Menggunakan **`Builder`** untuk memungkinkan definisi **blok skema yang berbeda** yang dapat diulang dalam urutan apa pun, ideal untuk struktur JSON yang kompleks. | |
| **Layout Tabel** | Keterbatasan responsivitas di *mobile*. | Menggunakan komponen `Layout` seperti `Grid`, `Stack`, dan `Split` di dalam `columns()` untuk membangun layout sel tabel yang responsif dan dapat menumpuk di *mobile*. | |
| **Pemrosesan Data Massal** | Memuat semua *record* ke memori secara *default*. | Opsi kinerja yang lebih baik: `chunkSelectedRecords(250)` untuk memproses dalam potongan kecil atau `fetchSelectedRecords(false)` untuk hanya mendapatkan ID *record* sebelum mengeksekusi aksi massal. | |

### 3. Modularitas dan Kualitas Kode

Filament v4 sangat menganjurkan pemisahan logika UI untuk menghindari metode *monolithic*.

*   **Resource:** Disarankan untuk memisahkan definisi `form()`, `table()`, dan `infolist()` ke dalam Kelas Schema dan Kelas Table/Infolist yang terpisah.
*   **Navigasi:** Pengenalan **`Clusters`** sebagai struktur hierarkis untuk mengelompokkan *Resources* dan *Custom Pages* secara logis, yang membantu mengurangi keruwetan *sidebar*.

## III. Rekapitulasi Kesalahan Transisi dan Solusi

Berdasarkan pengalaman Anda dan inti perubahan di v4, berikut adalah rangkuman kesalahan yang harus selalu Anda perhatikan:

| Kode Kesalahan | Penyebab Utama di Filament 4 | Solusi Langkah-demi-Langkah | Sumber |
| :--- | :--- | :--- | :--- |
| `Class "Filament\Forms\Components\Section" not found` | Komponen struktural (`Section`, `Grid`, `Group`, dll.) telah dipindahkan dari `Forms` ke `Schemas`. | Ganti `use Filament\Forms\Components\Section;` menjadi **`use Filament\Schemas\Components\Section;`**. | |
| `Type of ...::$navigationGroup must be UnitEnum|string|null` | Tipe data `UnitEnum` tidak diimpor, melanggar pemeriksaan tipe ketat PHP (memerlukan PHP 8.2+). | Tambahkan **`use UnitEnum;`** di bagian atas file Resource atau Page. | |
| `Property [$form] not found on component: [app.filament.pages.CustomPage]` | Komponen *Custom Page* kustom tidak mengadopsi *trait* yang menginisialisasi Form Builder Filament. | 1. Implementasikan `implements HasForms`. 2. Gunakan `use InteractsWithForms;`. 3. Definisikan `protected function form(Form $form): Form` dengan `->statePath('data')`. | |
| `Argument #1 ($form) must be of type Filament\Forms\Form, Filament\Schemas\Schema given` | Konflik *type hint* pada *Custom Page* karena menggunakan *signature* Form Resource statis. | Pastikan metode pada Custom Page menggunakan *signature* **`protected function form(Form $form): Form`** untuk konfigurasi *instance* Form. | |

Dengan menguasai pemisahan `Schemas` vs. `Forms` dan persyaratan *type hinting* yang ketat di PHP 8.2+, Anda dapat dengan mudah membangun antarmuka admin PPDB yang canggih dan *clean* di Filament 4.
