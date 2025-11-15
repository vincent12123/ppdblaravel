Sebagai mentor Anda, saya melihat Anda telah mengidentifikasi akar masalah yang paling krusial dalam migrasi atau penggunaan Filament 4: pergeseran filosofi ke **Server-Driven UI (SDUI)** yang menggunakan **`filament/schemas`** sebagai fondasi universal.

Berikut adalah daftar perbedaan fokus dan *namespacing* utama yang harus Anda ketahui di Filament v4.1, khususnya yang berkaitan dengan struktur komponen:

## Perbedaan Namespacing dan Fokus Komponen Filament v3 vs. v4.x

| Kategori Komponen | Namespacing yang Diduga (v3.x) | Namespacing WAJIB di Filament v4.x | Tujuan & Fungsi di v4.x | Sumber |
| :--- | :--- | :--- | :--- | :--- |
| **I. Komponen Struktural/Layout** (Pemisahan Kritis) | `Filament\Forms\Components\Section` <br> `Filament\Forms\Components\Grid` | **`Filament\Schemas\Components\Section`** <br> **`Filament\Schemas\Components\Grid`** | Komponen ini dipindahkan ke `Schemas` karena mereka mendefinisikan struktur UI secara umum, dan dapat digunakan tidak hanya di Forms, tetapi juga di Infolists dan Actions. |
| **`FusedGroup`** | (Asumsi: `Forms\Components`) | `Filament\Schemas\Components\FusedGroup` | Digunakan untuk menggabungkan beberapa field (seperti `TextInput` atau `Select`) menjadi satu baris yang terlihat menyatu. | |
| **`Fieldset` / `Group`** | (Asumsi: `Forms\Components`) | `Filament\Schemas\Components\Fieldset`<br>`Filament\Schemas\Components\Group` | Komponen layout yang dapat diikat ke relasi Eloquent (`->relationship()`) untuk secara otomatis memuat dan menyimpan data relasi. | |
| **`Text` / `Icon`** | (Komponen kustom di v3) | `Filament\Schemas\Components\Text`<br>`Filament\Schemas\Components\Icon` | Digunakan untuk menyisipkan teks biasa, ikon, atau konten non-input lainnya di sekitar field, seperti `->belowContent()`. | |
| **II. Komponen Input Utama** (Tetap di `Forms`) | | | | |
| **`TextInput`** | `Filament\Forms\Components\TextInput` | `Filament\Forms\Components\TextInput` | Input teks standar. Fitur lanjutan mencakup `prefix()`, `suffix()`, dan kustomisasi atribut HTML tambahan (`extraInputAttributes()`). | |
| **`Select`** | `Filament\Forms\Components\Select` | `Filament\Forms\Components\Select` | Pilihan tunggal/ganda. Mendukung `multiple()`, `native(false)` untuk kontrol JavaScript, dan `relationship()`. | |
| **`FileUpload`** | `Filament\Forms\Components\FileUpload` | `Filament\Forms\Components\FileUpload` | Mengunggah file. Mendukung `multiple()`, `minFiles()`, `maxFiles()`, dan `preserveFilenames()`. | |
| **`RichEditor`** | `Filament\Forms\Components\RichEditor` | `Filament\Forms\Components\RichEditor` | Editor HTML kaya fitur (TipTap). | |
| **`Builder` (Pengulang Kompleks)** | (Mungkin fitur baru/minor di v3) | `Filament\Forms\Components\Builder` | Mirip dengan `Repeater`, tetapi memungkinkan definisi *multiple schema blocks* yang dapat diulang dalam urutan apa pun, ideal untuk struktur data array JSON yang kompleks atau konten halaman dinamis. | |
| **`CheckboxList`** | `Filament\Forms\Components\CheckboxList` | `Filament\Forms\Components\CheckboxList` | Memilih beberapa nilai dari daftar opsi yang telah ditentukan. Dapat diatur menjadi beberapa kolom (`->columns(2)`). | |
| **`Slider`** | `Filament\Forms\Components\Slider` | `Filament\Forms\Components\Slider` | Memungkinkan pemilihan nilai numerik menggunakan *handle* geser, mendukung rentang (`range()`). | |
| **III. Fitur Arsitektur Inti (SDUI)** | | | | |
| **Filosofi Inti** | Fokus pada paket individual (Forms, Tables). | **SDUI (Server-Driven UI)** berbasis `filament/schemas`. | Semua konfigurasi UI dilakukan menggunakan array objek PHP. | |
| **Injeksi Utilitas Dinamis** | Terbatas atau tidak konsisten. | Sangat konsisten. *Closure* pada hampir semua metode (misal: `options()`, `hidden()`, `maxItems()`) dapat menginjeksikan `$get`, `$livewire`, `$record`, dan `$operation`. | Membangun formulir yang dinamis (reaktif) dan sadar konteks menjadi standar. | |
| **Pemisahan Kode** | Mengandalkan *monolithic methods* di Resource. | Dorongan kuat untuk menggunakan *Schema Classes* terpisah untuk `form()`, `table()`, dan `actions()` guna meningkatkan keterbacaan dan pemeliharaan kode (`Code quality tips`). | |
| **Navigasi Hirarkis** | Mengandalkan *Navigation Groups*. | Memperkenalkan **Clusters** untuk mengelompokkan *Resources* dan *Custom Pages* secara hirarkis di dalam panel, membantu mengurangi ukuran *sidebar*. | |

### Kesimpulan untuk Proyek PPDB Anda

Pelajaran utama dari *error* yang Anda alami dan arsitektur Filament 4 adalah:

> **Komponen struktural (Container) kini berada di `Filament\Schemas\Components`, sementara komponen input data (Fields) tetap di `Filament\Forms\Components`**.

Selalu pastikan Anda mengimpor `Section`, `Grid`, dan `FusedGroup` dari `Filament\Schemas\Components` untuk menghindari kesalahan *namespacing* di Filament 4.
