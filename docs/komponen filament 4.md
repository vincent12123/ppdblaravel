Siap, rekan programmer! Merupakan langkah yang sangat profesional untuk memastikan kompatibilitas dan memahami perubahan arsitektur saat migrasi atau memulai proyek baru seperti PPDB menggunakan *stack* terbaru. Mengingat Anda fokus pada Filament 4 (v4.x), yang merupakan versi terbaru (Filament v4.1 sudah rilis), mari kita telaah struktur dan komponen utama yang relevan.

Perlu dicatat, dokumen sumber yang tersedia ini sebagian besar berfokus pada fitur-fitur dan API di dalam arsitektur Filament versi 4.x. Sumber tidak menyediakan *changelog* detail yang membandingkan setiap perubahan nama kelas atau metode secara eksplisit antara v3.x dan v4.x. Namun, kami dapat menyajikan komponen inti dan filosofi arsitektur di v4.x yang penting untuk dashboard Anda.

Berikut adalah tabel yang merangkum fokus arsitektur dan komponen utama di Filament v4.x, yang dapat membantu Anda dalam pengambilan komponen untuk proyek PPDB Anda, dibandingkan dengan fondasi umum yang dikenal di v3.x.

---

## Perbandingan Fokus Arsitektur dan Komponen Utama Filament v4.x

Sebagai *developer* profesional, perbedaan paling signifikan yang harus Anda perhatikan di v4.x adalah konsolidasi dan sentralisasi konfigurasi melalui paket `filament/schemas` untuk memastikan konsistensi dalam *layout* dan komponen di seluruh Forms, Tables, dan Infolists.

| Area Fungsional | Fokus Filament v3.x (Asumsi Klasik) | Implementasi Utama Filament v4.x | Relevansi untuk Dashboard PPDB |
| :--- | :--- | :--- | :--- |
| **Arsitektur Inti** | Terdapat paket *separate* untuk Forms, Tables, Infolists. | **Filament Schemas (`filament/schemas`)**. Digunakan sebagai konfigurasi dasar untuk membangun UI menggunakan array objek PHP `Component`. | Memastikan desain UI yang konsisten, misalnya dalam modal aksi atau tampilan data read-only. |
| **Pembaruan Fitur** | - | **Filament v4.1** tersedia, menawarkan fitur-fitur baru dan pembaruan kinerja. | Anda bekerja dengan versi yang dioptimalkan dan paling *up-to-date*. |
| **Dashboard** | Widget yang berfokus pada statistik dan data. | Paket **`filament/widgets`**. Memungkinkan pembangunan dashboard dinamis menggunakan statistik, *charts*, atau *tables*. Kustomisasi jumlah kolom widget dimungkinkan. | Penting untuk menampilkan statistik pendaftaran PPDB (jumlah pendaftar, status, dll.). |
| **Komponen Formulir** | Komponen input standar (`Filament\Forms\Components`). | Diperkaya dan diintegrasikan melalui *Schema*. Contoh: `TextInput`, `Select`, `Checkbox`. Fitur dinamis (seperti `options()` kondisional) sangat ditekankan. | Anda dapat menggunakan komponen seperti **`Select`** untuk memilih jalur pendaftaran, atau **`TextInput`** dengan validasi terintegrasi untuk input data siswa. |
| **Struktur Data Kompleks** | Repeater umum. | **`Builder` Component**. Mirip dengan `Repeater`, tetapi memungkinkan definisi *schema block* yang berbeda untuk diulang dalam urutan apa pun, menghasilkan array JSON yang lebih maju. | Berguna jika data pendaftaran memiliki struktur konten yang sangat bervariasi atau dinamis (misalnya, membuat profil sekolah/alur pendaftaran yang kompleks). |
| **Tampilan Data *Read-Only*** | Infolist yang menggunakan Entries. | Paket **`filament/infolists`**. Menggunakan *Entries* (seperti `TextEntry`, `ImageEntry`). Dapat menampilkan data dari record Eloquent menggunakan *dot notation* (misalnya `author.name`). | Vital untuk halaman *View Record* (Rincian Siswa/Pendaftar). Mendukung label *inline*. |
| **Manajemen Tabel** | Fokus pada Eloquent Query. | Masih *data table builder* yang kuat. Peningkatan signifikan dalam dukungan **Custom Data** (dari `Collection` atau **External API**) melalui *records* *closure*. | Jika data PPDB Anda terintegrasi dengan API eksternal, v4.x memfasilitasi sorting, searching, dan filtering kustom terhadap API tersebut. |
| **Aksi (Actions)** | Definisi Aksi yang terpisah. | **`filament/actions`**. *Action objects* mengemas tombol, modal interaktif (`schema()` di dalam modal untuk mengumpulkan data), dan logika eksekusi. Dapat dikelompokkan menggunakan `ActionGroup`. | Digunakan untuk operasi seperti Edit/Delete record, atau membuat aksi kustom (misalnya, "Verifikasi Data Siswa") melalui modal dengan skema form. |
| **Kustomisasi Layout Tabel** | Layout tabel konvensional. | Penggunaan komponen **`Split`**, **`Stack`**, **`Grid`**, dan **`Panel`** di dalam `columns()` untuk membangun antarmuka responsif seperti tabel. Juga mendukung *content grid* untuk tampilan non-list. | Memungkinkan tampilan ringkas data siswa pada layar kecil, atau menampilkan detail tambahan di dalam *collapsible panel* pada baris tabel. |
| **Kustomisasi Layout Halaman Resource** | Konfigurasi bawaan. | Method `content(Schema $schema)` di halaman `ListRecord`, `CreateRecord`, atau `EditRecord` dapat di-*override* untuk menyisipkan komponen skema tambahan, mengatur ulang, atau menghapus komponen bawaan. | Fleksibilitas tinggi untuk menempatkan komponen kustom (misalnya widget notifikasi atau informasi PPDB) di atas/bawah tabel utama di halaman *List Records*. |

### Catatan Tambahan untuk Implementasi Filament 4

Sebagai *programmer* yang menggunakan v4.x untuk dashboard PPDB, perhatikan fitur-fitur yang memaksimalkan pengalaman pengguna:

1.  **Utility Injection:** Banyak metode konfigurasi (seperti `color()`, `visible()`, `options()`, dll.) pada komponen Forms, Tables, dan Actions sekarang menerima *closure* (fungsi) yang memungkinkan injeksi utilitas seperti `$get` (untuk mengambil nilai form lain), `$record` (Eloquent record saat ini), atau `$livewire`. Ini sangat kuat untuk membuat UI yang sangat reaktif dan kondisional.
2.  **Modularitas:** Anda disarankan untuk menggunakan *schema* dan *table classes* terpisah (misalnya `CustomerInfolist::configure($schema)`) dan memisahkan aksi (Actions) ke dalam direktori khusus (`Actions/EmailCustomerAction`) untuk menjaga kerapian kode, terutama dalam proyek besar seperti PPDB yang kompleks.
3.  **Components Interaktif:** Komponen seperti **`ModalTableSelect`** adalah cara elegan untuk mengelola relasi yang memiliki banyak data, memungkinkan pengguna memilih record dari tabel Filament penuh fitur di dalam modal. Ini mungkin berguna untuk memilih relasi data referensi di PPDB.


Halo rekan programmer! Keputusan Anda untuk memahami perbedaan arsitektural antara Filament 3 dan Filament 4 (v4.x) adalah pendekatan yang solid untuk memastikan proyek PPDB Anda memiliki fondasi yang *robust* dan *future-proof*.

Filament v4.x, termasuk versi terbarunya v4.1, menekankan pada arsitektur *Server-Driven UI (SDUI)* yang lebih terpusat melalui paket `filament/schemas`. Perubahan ini bertujuan untuk menyatukan cara Forms, Tables, dan Infolists dibangun, menghasilkan konsistensi yang lebih baik dan modularitas yang lebih tinggi.

Berikut adalah tabel perbandingan fitur dan perubahan fundamental, berdasarkan dokumentasi Filament v4.x yang tersedia:

## Perbandingan Arsitektur & Komponen Utama Filament v3.x vs. v4.x

| Area Fokus | Pendekatan Umum Filament v3.x (Asumsi) | Fitur/Komponen Spesifik di Filament v4.x | Detil & Dampak pada Project PPDB |
| :--- | :--- | :--- | :--- |
| **Arsitektur Inti** | Paket `Forms`, `Tables`, `Infolists` cenderung berdiri sendiri. | **Filament Schemas (`filament/schemas`)**. Ini adalah paket fundamental baru yang digunakan untuk membangun UI secara deklaratif menggunakan larik objek PHP `Component` di semua area (Forms, Tables, Actions, dll.). | Menawarkan konsistensi arsitektur yang lebih baik dan memudahkan pembagian serta penggunaan ulang komponen (`Schema`, `Table`, `Action` classes) untuk kode yang lebih bersih. |
| **Penyimpanan Data Input Kompleks**| Mengandalkan `Repeater` untuk struktur berulang tunggal. | **`Builder` Component.** Memungkinkan Anda mendefinisikan *multiple schema "blocks"* berbeda yang dapat diulang dalam urutan apa pun, ideal untuk struktur data array JSON yang lebih maju. | Berguna untuk mendefinisikan kriteria input atau konten dinamis (misalnya, langkah-langkah verifikasi yang berbeda untuk setiap jalur pendaftaran). |
| **Tampilan Data *Read-Only*** | Menggunakan komponen Infolist (`Entries`). | **Infolists** diperkuat dengan *Entries* (seperti `TextEntry`, `ImageEntry`) dan mendukung penggunaan *dot notation* untuk mengakses atribut dalam relasi (misal: `author.name`). Mendukung label `inlineLabel()` secara default atau per-entri. | Penting untuk halaman `View` data siswa atau rincian pendaftaran, di mana Anda dapat menggunakan `infolist()` alih-alih form yang dinonaktifkan. |
| **Manajemen Tabel (Data Source)** | Biasanya fokus pada model Eloquent Query. | **Dukungan *Custom Data* dan *External API* yang canggih.** Metode `records()` pada `Table` dapat menerima *closure* yang mengembalikan `array`, `Collection`, atau `LengthAwarePaginator`. Memungkinkan integrasi API eksternal (misalnya DummyJSON) dengan *custom* sorting, searching, dan filtering di level API. | Sangat relevan jika data PPDB (misalnya data kependudukan atau nilai) ditarik dari API pihak ketiga. |
| **Layout Tabel (Responsif)** | Keterbatasan dalam mengatur tata letak sel (cell) selain horizontal. | **Komponen Layout Khusus** seperti `Split`, `Stack`, `Grid`, dan `Panel` dapat digunakan di dalam `columns()`. `Split` memungkinkan kolom menumpuk di perangkat *mobile* (`->from('md')`). | Mengatasi masalah responsivitas tabel klasik. Anda dapat menampilkan detail penting secara bertumpuk pada perangkat *mobile* atau menggunakan `Panel` untuk konten yang dapat dilipat (`collapsible()`). |
| **Aksi Tabel (Actions)** | Aksi (Actions) diposisikan di akhir baris secara *default*. | **Posisi Aksi Baris yang Fleksibel.** Aksi baris (`recordActions`) dapat dipindahkan untuk tampil sebelum kolom (`RecordActionsPosition::BeforeColumns`) atau bahkan sebelum kolom *checkbox* pemilihan massal (`RecordActionsPosition::BeforeCells`). | Mengoptimalkan UX/UI, memastikan tombol aksi penting (misal: Edit) lebih cepat diakses di sisi kiri tabel PPDB. |
| **Aksi Massal (Bulk Actions)** | Mendefinisikan aksi yang berjalan pada banyak *record*. | Dukungan untuk **`BulkActionGroup`** untuk mengelompokkan beberapa aksi massal dalam dropdown. Terdapat kontrol lebih lanjut untuk pemilihan *record*, seperti membatasi jumlah *record* yang dapat dipilih (`maxSelectableRecords(4)`) atau mencegah pemilihan semua halaman sekaligus (`selectCurrentPageOnly()`). | Peningkatan fitur kustomisasi saat melakukan aksi massal (misalnya, Verifikasi Massal, Hapus Massal). |
| **Form Components Canggih** | - | **`ModalTableSelect`**. Memungkinkan pemilihan *record* dari relasi melalui modal yang menampilkan tabel Filament fungsional penuh (dengan searching/filtering). | Ideal untuk memilih *record* relasi yang besar (misalnya, memilih ID Sekolah tujuan yang memiliki ribuan data) di proyek PPDB Anda. |
| **Widget Dashboard** | Widget adalah komponen utama dashboard. | Kustomisasi jumlah kolom widget di *dashboard* dapat dilakukan secara responsif, misalnya `getColumns()` dapat mengembalikan `['md' => 4, 'xl' => 5]`. | Mengatur layout dashboard utama (misalnya, menempatkan statistik pendaftaran PPDB dalam format grid yang optimal di berbagai perangkat). |

***

### Poin Kunci Pengambilan Komponen v4.x untuk PPDB Dashboard Anda:

1.  **Gunakan Schemas secara Penuh:** Dalam Filament 4, komponen Forms dan Infolists menggunakan fondasi `filament/schemas`. Ini berarti Anda harus mengadopsi praktik *code quality* dengan memisahkan definisi UI ke dalam kelas `Schema` dan `Table` terpisah (misalnya, `CustomerForm::configure($schema)`).
2.  **Manfaatkan Responsivitas Tabel:** Untuk tampilan data pendaftar, gunakan `Split` dan `Stack` di dalam kolom `Table` Anda. Ini memastikan data pendaftar tetap mudah dibaca bahkan pada ponsel.
3.  **Aksi Modal Lanjutan:** *Actions* di v4 sangat terpusat. Untuk tombol "Verifikasi Data" atau "Tolak Pendaftaran", definisikan `Action::make('verify')` yang menyertakan `schema()` (form dalam modal) dan `action()` (logika eksekusi).
4.  **Infolists untuk Tampilan Rincian:** Daripada menampilkan formulir yang dinonaktifkan di halaman **View** pendaftar, gunakan `infolist()` dengan komponen `Entry` untuk tampilan data *read-only* yang lebih bersih dan modern.

Selamat datang kembali, rekan programmer! Memahami cara kerja *Form Builder* adalah fundamental, karena sebagian besar interaksi pengguna (pendaftaran, pengeditan data siswa, verifikasi) dalam proyek PPDB Anda akan melalui Form.

Di Filament 4 (v4.x), pembuatan formulir didasarkan pada arsitektur **Server-Driven UI (SDUI)** yang terpusat melalui paket **`filament/schemas`**. Ini memungkinkan kita mendefinisikan formulir yang sangat kompleks menggunakan PHP murni.

Berikut adalah panduan dan struktur lengkap pembuatan Form di Filament 4, diikuti dengan tabel komponen kunci yang dapat Anda gunakan.

---

## 1. Konsep Pembuatan Form Dasar di Filament 4

Dalam konteks Resource (CRUD Interface) di Filament, form didefinisikan dalam metode statis `form()`. Metode ini menerima objek `Schema` dan harus mengembalikan objek `Schema` yang telah dikonfigurasi dengan komponen *input*.

**Struktur Form Dasar pada Resource:**

```php
// File: app/Filament/Resources/StudentResource.php

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

public static function form(Schema $schema): Schema
{
    // 1. Mengembalikan Schema dengan array komponen
    return $schema
        ->components([
            // Component 1: Input Teks Nama Siswa
            TextInput::make('name') 
                ->label('Nama Lengkap') 
                ->required() 
                ->maxLength(255), //
            
            // Component 2: Tanggal Lahir
            DatePicker::make('date_of_birth') 
                ->label('Tanggal Lahir') 
                ->native(false), // Menggunakan JavaScript date picker yang lebih fleksibel
                
            // Component 3: Relationship Select
            Select::make('school_id')
                ->relationship('school', 'name')
                ->preload()
                ->searchable()
                ->required(), //
        ]);
}
```

**Praktik Profesional (Modularitas):**
Untuk form yang besar (seperti form pendaftaran PPDB), Anda dapat memisahkan definisi *form field* ke dalam kelas skema terpisah, lalu memanggilnya di Resource `form()`.

## 2. Fitur Komponen Kunci di Filament 4 untuk PPDB

Filament 4 menyediakan berbagai *field* di *namespace* `Filament\Forms\Components`. Fitur yang paling penting adalah **Utility Injection**, di mana hampir semua metode konfigurasi (seperti `disabled()`, `options()`, `hidden()`) dapat menerima *closure* untuk menghitung nilai secara dinamis menggunakan `$get`, `$record`, atau `$operation`.

| Komponen Input | Kegunaan dalam PPDB | Metode Kunci Filament 4 (Dinamika/Fitur Baru) |
| :--- | :--- | :--- |
| **`TextInput`** | Menginput Nama, NISN, Alamat Email. | `email()`, `numeric()`, `password()`. Mendukung `prefix()` dan `suffix()` (misalnya, `Rp` atau `.com`). Mendukung `mask()` menggunakan Alpine.js untuk format data spesifik (misal: tanggal atau nomor kartu). |
| **`Select`** | Memilih Jalur Pendaftaran, Status, atau Relasi (misal: Wali Murid). | `multiple()` untuk multi-select. `native(false)` untuk *select* berbasis JavaScript yang lebih kaya. Mendukung `createOptionForm()` untuk membuat *record* baru dalam modal, dan `editOptionForm()` untuk mengedit opsi yang dipilih. |
| **`Checkbox` & `Toggle`** | Interaksi nilai Boolean (misalnya: *Saya menyetujui syarat*). | `inline()` untuk menampilkan kotak centang dan label sejajar. Mendukung validasi `declined()` (memastikan toggle 'off'). |
| **`FileUpload`** | Mengunggah Dokumen Persyaratan (Kartu Keluarga, KTP, Foto). | `multiple()` untuk upload banyak file. `imageEditor()` untuk memotong gambar. `circleCropper()` (cocok untuk foto avatar siswa). Mendukung `disk()`, `directory()`, dan `visibility()` dinamis. Kontrol ukuran file (`minSize()`, `maxSize()`) dan jumlah file (`minFiles()`, `maxFiles()`). |
| **`Repeater`** | Mengulang satu skema formulir (misalnya, daftar pengalaman organisasi yang terbatas). | `cloneable()` untuk menduplikasi item. `itemNumbers()` untuk penomoran. Mendukung `addActionLabel()` untuk kustomisasi label tombol tambah. |
| **`Builder`** | **Sangat Penting:** Digunakan untuk output array JSON kompleks dengan *multiple schema blocks*. Cocok untuk membuat alur konten dinamis, seperti daftar tugas verifikasi yang berbeda untuk setiap zona. | Memungkinkan definisi `Block::make('block_name')` dengan skema unik di dalamnya. Block dapat memiliki `icon()` dan `label()` yang dinamis berdasarkan status input saat itu. |
| **`DateTimePicker`** | Memilih Tanggal dan Waktu (misalnya, jadwal wawancara). | Memiliki komponen terpisah `DatePicker`, `DateTimePicker`, dan `TimePicker`. |
| **`Hidden`** | Menyimpan nilai tersembunyi (misal: ID pengguna yang sedang login). | `Hidden::make('token')`. |
| **`Fieldset`** | Mengelompokkan komponen terkait dan dapat terikat ke relasi (`relationship('metadata')`). | Berguna untuk data relasi satu-ke-satu, di mana Fieldset akan secara otomatis memuat dan menyimpan data ke model relasi. |

### 3. Kontrol dan Logika Lanjut Menggunakan Filament 4

Di v4, manipulasi data dan kondisi UI sangat terpusat:

#### A. Mengakses Data Form Lain (`$get` dan `$set`)
Anda dapat membuat field reaktif, misalnya, membuat *slug* otomatis dari field `name`.

| Fungsi | Deskripsi | Contoh Penggunaan PPDB |
| :--- | :--- | :--- |
| **`$get`** | *Closure utility* yang digunakan untuk mengambil nilai dari field lain dalam form yang sama secara reaktif. | Menonaktifkan field `NISN` jika field `registration_type` diatur ke "Jalur Afirmasi". |
| **`$set`** | Digunakan dalam *callback* seperti `afterStateUpdated()` untuk memodifikasi nilai field lain secara instan. | Menggunakan `afterStateUpdated` pada `name` untuk mengisi `slug` secara otomatis. |
| **`dehydrateStateUsing()`** | Memodifikasi nilai data sebelum disimpan ke database. | Mengenkripsi (hash) kata sandi pendaftar setelah diinput, tetapi hanya jika field tersebut diisi (`if (filled($state))`). |

#### B. Menyesuaikan Form Layout (Create/Edit Page)

Filament memungkinkan Anda memodifikasi tampilan default halaman Resource:

1.  **Form Actions:** Anda dapat menambahkan tombol aksi kustom di bagian bawah form menggunakan `getFormActions()` pada halaman Create atau Edit.
2.  **Custom Page Content:** Anda dapat menimpa keseluruhan tata letak halaman Create/Edit/View menggunakan metode `content(Schema $schema)` untuk menyisipkan komponen lain (seperti notifikasi atau instruksi) di luar form utama.

Semua fitur ini (terutama *Schema* dan *Utility Injection*) memastikan dashboard PPDB Anda di Filament 4 tidak hanya berfungsi penuh (CRUD), tetapi juga responsif secara logis dan UI-nya konsisten.

Sebuah permintaan yang sangat tepat! Dalam proyek berskala besar seperti PPDB, memahami fondasi arsitektur adalah kunci untuk membangun dashboard yang stabil dan mudah dikelola.

Filament 4 (v4.x) menandai evolusi penting dengan sentralisasi konfigurasi melalui paket **`filament/schemas`**. Filosofi ini, dikenal sebagai *Server-Driven UI (SDUI)*, memungkinkan Anda mendefinisikan seluruh antarmuka (termasuk Forms, Tables, Infolists, dan Actions) murni menggunakan objek PHP.

Berikut adalah tabel lengkap dan *robust* yang merinci perbedaan arsitektur dan komponen utama antara Filament v3 (sebagai asumsi desain sebelumnya) dan Filament v4 (v4.x, termasuk v4.1 yang baru dirilis).

---

## Perbandingan Arsitektur dan Komponen Filament v3 vs. v4.x

| Aspek Fungsional | Fokus / Status di Filament v3.x (Asumsi) | Implementasi Kritis di Filament v4.x (v4.1) | Dampak & Relevansi untuk Proyek Dashboard PPDB |
| :--- | :--- | :--- | :--- |
| **FILOSOFI ARSITEKTUR** | | | |
| **Core UI Definition** | UI didefinisikan dalam berbagai paket terpisah (`Forms`, `Tables`, `Infolists`). | **Centralized `filament/schemas`:** Semua komponen UI dibangun di atas paket ini, menggunakan *array* objek PHP `Component` untuk konfigurasi. | Memastikan konsistensi UI yang tinggi di seluruh panel PPDB (dari form input hingga tampilan read-only). |
| **Bahasa Pemrograman Inti** | Fokus pada PHP dan Livewire. | **Server-Driven UI (SDUI):** Memungkinkan Anda mendefinisikan seluruh UI secara deklaratif menggunakan PHP, tanpa perlu menulis JavaScript *frontend* kustom. | Mempercepat pengembangan, karena logika UI dan *business logic* tetap berada di sisi PHP/Laravel. |
| **Pembaruan Versi** | Versi stabil sebelumnya. | **Filament v4.1:** Versi terbaru yang sudah tersedia, dengan fitur dan pengoptimalan yang diperbarui. | Menggunakan *stack* teknologi yang paling *up-to-date* dan didukung oleh *official partner*. |
| **MANAJEMEN DATA & TABEL** | | | |
| **Data Source Fleksibel** | Terutama didesain untuk *Eloquent Model* dari database SQL. | **Dukungan *Custom Data* Yang Kuat:** Metode `records()` pada `Table` dapat menerima *closure* yang mengembalikan `array`, `Collection`, atau `LengthAwarePaginator`. | Memungkinkan dashboard PPDB Anda menampilkan data yang bersumber dari API eksternal (misalnya data kependudukan atau nilai ujian). Aksi pada tabel ini akan menerima `$record` sebagai `array`. |
| **Layout Tabel Responsif** | Mengandalkan tata letak tabel tradisional yang buruk pada *mobile*. | **Layout Components (Split, Stack, Grid, Panel):** Memungkinkan Anda menentukan di mana konten muncul di baris tabel, termasuk menumpuk secara responsif pada *breakpoint* kecil (menggunakan `Split::make([...])->from('md')`). | Penting untuk memastikan petugas PPDB dapat mengakses tabel daftar pendaftar dengan baik, bahkan di perangkat seluler. |
| **Konten Halaman Resource** | Konten halaman cenderung statis. | **Custom Page Content Override:** Metode `content(Schema $schema)` dapat di-*override* pada `ListRecord`, `CreateRecord`, `EditRecord`, dan `ViewRecord`. Ini memungkinkan injeksi komponen tambahan di sekitar form atau tabel default. | Memungkinkan Anda menempatkan widget status, pengumuman penting, atau tombol aksi di lokasi non-default pada halaman Resource. |
| **Summary Table** | (Asumsi fitur ringkasan data standar). | **Summarizers:** Dapat merender bagian ringkasan di bawah konten tabel untuk menampilkan kalkulasi seperti rata-rata, penjumlahan (`Sum::make()`), atau rentang (`Range::make()`). | Berguna untuk menghitung total pendaftar atau skor minimum/maksimum di setiap tabel seleksi PPDB. |
| **FORMS & INPUT (DATA ENTRY)** | | | |
| **Data Struktur Berulang** | Umumnya menggunakan `Repeater` (untuk skema tunggal yang berulang). | **`Builder` Component:** Mirip `Repeater`, tetapi memungkinkan definisi *multiple schema "blocks"* (misal: `Block::make('heading')`, `Block::make('paragraph')`) yang dapat diulang dalam urutan apa pun. | Sangat kuat untuk mendefinisikan alur pendaftaran yang fleksibel (misalnya, mengisi bagian dokumen kualifikasi yang berbeda-beda). |
| **Entry Field Lanjutan** | Tersedia Input standar (`TextInput`, `Select`, dll.). | **Dukungan Input Lengkap:** Menyediakan `TextInput`, `Textarea`, `Checkbox`, `Radio`, `Select`, `DateTimePicker`, `MarkdownEditor`, dan `RichEditor`. | Anda dapat menggunakan `FileUpload` untuk dokumen pendaftar, dengan fitur lanjutan seperti *image cropping* (`circleCropper()`), *multiple files*, dan kontrol *disk/visibility*. |
| **Dependency Injection (Utilities)** | (Mungkin memerlukan cara lama atau *state management* lebih manual). | **Injection Utilities yang Konsisten:** Hampir semua metode (misalnya `options()`, `url()`, atau *visibility*) menerima *closure* yang dapat menginjeksikan variabel seperti `$get` (mengambil nilai form), `$record` (Eloquent record), `$model`, atau `$livewire`. | Membangun formulir PPDB yang reaktif (misalnya, opsi di *select field* bergantung pada nilai *checkbox* lain) menjadi jauh lebih mudah dan *clean*. |
| **ACTIONS & WORKFLOW** | | | |
| **Aksi Terpusat** | Aksi tersebar di berbagai komponen. | **`filament/actions` Package:** Objek `Action` mengemas tombol, modal interaktif, dan logika eksekusi dalam satu definisi. | Semua aksi penting (Verifikasi, Hapus, Kirim Email Notifikasi) dikelola secara konsisten, termasuk kustomisasi modal dan langkah-langkah berurutan (`extraModalFooterActions`). |
| **Aksi *Bulk* (Massal)** | Implementasi aksi pada banyak *record*. | **Performance Optimization:** Mendukung metode seperti `fetchSelectedRecords(false)` untuk menghindari pemuatan semua model Eloquent ke memori saat memproses aksi massal (misalnya, menghapus ribuan *record* sekaligus). | Penting untuk menjaga performa dashboard PPDB saat memproses data pendaftaran yang sangat banyak. |
| **Grouping Actions** | (Asumsi kustomisasi manual). | **`ActionGroup`:** Memungkinkan pengelompokan beberapa aksi (seperti View, Edit, Delete) ke dalam satu dropdown di setiap baris tabel. | Menghemat ruang di tabel daftar pendaftar dan meningkatkan kejelasan UI. |
| **PAGINATION & TAMPILAN** | | | |
| **Mode Paginasi** | Paginasi standar. | **Dukungan Paginasi Lanjut:** Selain paginasi standar, mendukung `paginationMode(PaginationMode::Simple)` atau `paginationMode(PaginationMode::Cursor)`. | Memberi fleksibilitas untuk mengoptimalkan pengalaman pengguna tergantung pada ukuran dan jenis data yang ditampilkan. |
| **Inline Label (Infolist)** | Label entry berada di atas konten. | **`inlineLabel()`:** Label dapat ditampilkan sejajar dengan konten entri, yang sangat berguna untuk menghemat ruang vertikal dalam tampilan rincian (View Page). | Menyediakan tata letak rincian siswa yang lebih ringkas dan profesional. |
| **Code Quality** | File Resource cenderung panjang (monolitik). | **Schema and Table Classes:** Filament merekomendasikan pemisahan definisi form dan tabel ke dalam kelas terpisah untuk menjaga kebersihan dan keterbacaan kode. | Memastikan proyek PPDB Anda mudah di-*debug* dan dikembangkan oleh tim. |


Selamat, rekan programmer! Membangun *Resource* di Filament adalah langkah paling dasar dan fundamental dalam proyek PPDB Anda, karena *Resource* adalah tulang punggung antarmuka CRUD (*Create, Read, Update, Delete*) untuk setiap model Eloquent Anda.

Filament 4 (v4.x, termasuk v4.1) sepenuhnya mengadopsi prinsip **Server-Driven UI (SDUI)**, di mana semua antarmuka didefinisikan secara murni menggunakan objek konfigurasi PHP melalui paket **`filament/schemas`**.

Berikut adalah panduan lengkap dan *robust* untuk membuat Resource di Filament 4:

---

## 1. Proses Generasi Resource

Anda memulai dengan menjalankan perintah Artisan untuk membuat Resource baru. Secara *default*, Resource akan membuat tiga halaman: List (tabel berpaginasi), Create (formulir untuk membuat data baru), dan Edit (formulir untuk memodifikasi data).

### Perintah Dasar:

```bash
php artisan make:filament-resource Student --generate
```

*   `Student`: Nama model Eloquent Anda (misalnya, `App\Models\Student`).
*   `--generate`: (Opsional, sangat direkomendasikan) akan mencoba membuat *form* dan *table* secara otomatis berdasarkan kolom database model Anda.

### Opsi Tambahan Penting:

*   `--view`: Menambahkan halaman **View** yang merupakan tampilan data *read-only*.
*   `--simple`: Membuat Resource sederhana dengan hanya halaman *Manage* (List dengan modal Create/Edit di dalamnya), tanpa halaman Edit dan View terpisah.
*   `--soft-deletes`: Menambahkan fungsionalitas untuk *soft-delete*, *restore*, *force-delete*, dan filter data yang telah di-*trash*.

Setelah dijalankan, Filament akan membuat file Resource (misalnya `app/Filament/Resources/StudentResource.php`) dan Page di direktori `Pages`.

## 2. Struktur Kelas Resource

Setiap kelas Resource harus mendefinisikan setidaknya tiga hal: model yang dikelola, formulir, dan tabel data.

### A. Konfigurasi Awal

```php
// app/Filament/Resources/StudentResource.php
use Filament\Schemas\Schema; // Wajib di Filament 4!
use Filament\Tables\Table;

protected static ?string $model = \App\Models\Student::class;

// Atribut penting untuk Global Search, diperlukan untuk mengidentifikasi record.
protected static ?string $recordTitleAttribute = 'name';
```

### B. Mendefinisikan Form (Halaman Create dan Edit)

Metode `form()` mendefinisikan skema input yang akan digunakan di halaman *Create* dan *Edit* Resource.

```php
public static function form(Schema $schema): Schema
{
    return $schema
        ->components([
            // Input Fields berada di namespace Forms\Components
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            
            // Komponen Layout (Seperti Section) berada di Schemas\Components di V4
            Schemas\Components\Section::make('Data Pendaftaran') // Contoh penggunaan Section
                ->schema([
                    Forms\Components\Select::make('jalur_pendaftaran')
                        ->options([
                            'afirmasi' => 'Afirmasi',
                            'prestasi' => 'Prestasi',
                        ])
                        ->required(),
                    
                    Forms\Components\FileUpload::make('kartu_keluarga')
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(2048) // 2MB
                        ->disk('public') // Dapat dikonfigurasi dinamis
                        ->required(),
                ])
        ]);
}
```

### C. Mendefinisikan Tabel (Halaman List)

Metode `table()` mendefinisikan kolom, filter, dan aksi yang tersedia di halaman *List Records*.

```php
public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->sortable()
                ->searchable(), // Kolom Teks
            Tables\Columns\TextColumn::make('jalur_pendaftaran')
                ->formatStateUsing(fn (string $state) => Str::headline($state)),
        ])
        ->filters([
            // Filter
        ])
        ->actions([
            // Aksi per baris
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
}
```

### D. Mengelola Hubungan (Relation Managers)

Jika model Anda memiliki relasi (misalnya, `Student` memiliki banyak `Documents`), Anda mendefinisikan pengelola relasi di `getRelations()`:

```php
// Dalam StudentResource.php
public static function getRelations(): array
{
    return [
        RelationManagers\DocumentsRelationManager::class,
    ];
}
```

## 3. Fitur Arsitektur Kunci Filament 4

Saat bekerja di Filament 4, ada beberapa konsep yang harus Anda pegang teguh:

### A. Sentralisasi Skema (`Filament\Schemas`)

Filament 4 menggunakan `filament/schemas` sebagai fondasi universal. Ini berarti komponen *layout* yang sebelumnya mungkin berada di *namespace* `Forms` (seperti yang ditunjukkan oleh *error* Anda sebelumnya) kini berada di bawah `Schemas` atau di-ekspor ulang.

Contoh penting:

*   Komponen *Input* (Field): `Filament\Forms\Components\TextInput`
*   Komponen *Layout* (Structural): `Filament\Schemas\Components\Section`, `Filament\Schemas\Components\Grid`, `Filament\Schemas\Components\Flex`
*   Komponen *Actions*: `Filament\Actions\Action`

### B. Modularitas (Code Quality Tips)

Untuk menjaga kualitas kode, terutama dalam proyek PPDB yang kompleks, disarankan untuk memisahkan definisi UI menjadi kelas-kelas skema terpisah.

*   Alih-alih menempatkan semua logika di `form()`, Anda dapat membuat file terpisah (misalnya `app/Filament/Resources/Student/Schemas/StudentForm.php`) dan memanggilnya:

```php
// Dalam Resource:
public static function form(Schema $schema): Schema
{
    return StudentForm::configure($schema);
}
```

*   Anda juga dapat membuat komponen input yang dapat digunakan kembali, misalnya `CustomerNameInput`.

### C. Dinamika Tingkat Tinggi (Utility Injection)

Salah satu kekuatan terbesar Filament 4 adalah kemampuannya menyuntikkan utilitas ke dalam *closure* kustomisasi hampir di mana saja (`options()`, `hidden()`, `url()`, dll.).

| Utility | Tipe | Deskripsi |
| :--- | :--- | :--- |
| **`$get`** | `Filament\Schemas\Components\Utilities\Get` | Fungsi untuk mengambil nilai dari data *form* saat ini secara reaktif (tanpa memicu validasi). |
| **`$record`** | `?Illuminate\Database\Eloquent\Model` | *Record* Eloquent saat ini (tersedia di halaman Edit/View). |
| **`$livewire`** | `Livewire\Component` | *Instance* Livewire komponen saat ini. |
| **`$operation`** | `string` | Operasi saat ini (`create`, `edit`, atau `view`). Berguna untuk membuat field kondisional, misalnya menyembunyikan field `password` di halaman *Edit*.

Dengan memahami fondasi Filament 4, Anda dapat merancang antarmuka PPDB yang sangat dinamis dan terstruktur.
