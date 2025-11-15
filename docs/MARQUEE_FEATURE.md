# Fitur Marquee - Dokumentasi

## Deskripsi
Fitur marquee menampilkan teks berjalan (scrolling text) di landing page yang dapat dikelola dari dashboard admin. Ideal untuk pengumuman penting, deadline pendaftaran, atau informasi umum.

## Komponen

### 1. Database
**Migration**: `2025_11_15_000001_create_marquees_table.php`
- `id`: Primary key
- `text`: Teks marquee (text)
- `is_active`: Status aktif/nonaktif (boolean, default: true)
- `order`: Urutan tampilan (integer, default: 0)
- `timestamps`: Created at & Updated at

### 2. Model
**File**: `app/Models/Marquee.php`

**Fillable Fields**:
- `text`
- `is_active`
- `order`

**Query Scopes**:
- `active()`: Filter marquee yang aktif
- `ordered()`: Urutkan berdasarkan order dan created_at

**Contoh Penggunaan**:
```php
// Ambil semua marquee aktif dan terurut
$marquees = Marquee::active()->ordered()->get();
```

### 3. Admin Interface (Filament)
**Resource**: `app/Filament/Resources/MarqueeResource.php`

**Form Fields**:
- **Teks Marquee**: Textarea (max 500 karakter)
- **Aktif**: Toggle (default: true)
- **Urutan**: Number input (default: 0)

**Table Columns**:
- Teks (dengan limit 50 karakter, searchable)
- Status (icon boolean)
- Urutan (sortable)
- Dibuat (toggleable)

**Lokasi Menu**: Navigasi group "Konten"

### 4. Tampilan Frontend
**File**: `resources/views/landing/layout.blade.php`

**Implementasi**:
```blade
@php
    $marquees = \App\Models\Marquee::active()->ordered()->get();
@endphp

@if($marquees->count() > 0)
<div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2 overflow-hidden">
    <div class="marquee-container">
        <div class="marquee-content">
            @foreach($marquees as $marquee)
                <span class="inline-block px-8">
                    <i class="fas fa-bullhorn mr-2"></i>
                    {{ $marquee->text }}
                </span>
            @endforeach
        </div>
    </div>
</div>
@endif
```

**CSS Animation**:
- Animasi scrolling 30 detik
- Hover untuk pause
- Gradient background (blue to purple)

### 5. Seeder
**File**: `database/seeders/MarqueeSeeder.php`

**Sample Data** (3 marquee):
1. Selamat datang di Portal PPDB Online! Daftarkan diri Anda sekarang untuk tahun ajaran baru.
2. Pendaftaran dibuka mulai 1 Juni 2025 sampai 30 Juni 2025. Jangan sampai terlewat!
3. Informasi lebih lanjut hubungi kami di nomor (021) 1234-5678 atau email: info@sekolah.sch.id

## Cara Menggunakan

### Menambah Marquee Baru
1. Login ke dashboard admin
2. Navigasi ke menu **Konten** → **Marquee**
3. Klik tombol **Create** (Buat)
4. Isi form:
   - **Teks Marquee**: Masukkan teks pengumuman (max 500 karakter)
   - **Aktif**: Toggle ON untuk menampilkan, OFF untuk menyembunyikan
   - **Urutan**: Angka kecil = tampil lebih awal (0, 1, 2, dst)
5. Klik **Save**

### Mengedit Marquee
1. Di halaman list Marquee, klik icon **Edit** pada marquee yang ingin diubah
2. Update field yang diperlukan
3. Klik **Save**

### Menonaktifkan Marquee
1. Edit marquee yang ingin dinonaktifkan
2. Toggle **Aktif** menjadi OFF
3. Klik **Save**
4. Marquee tidak akan ditampilkan di landing page, tapi data tetap tersimpan

### Mengatur Urutan Tampilan
- Semakin kecil nilai **Urutan**, semakin awal ditampilkan
- Contoh: Marquee dengan order 0 tampil sebelum order 1
- Jika order sama, diurutkan berdasarkan waktu dibuat (terbaru dulu)

## Fitur Teknis

### Animasi Marquee
- **Durasi**: 30 detik per loop
- **Arah**: Kanan ke kiri
- **Hover**: Pause saat mouse hover
- **Smooth**: Linear infinite animation

### Performance
- Query hanya marquee aktif (`is_active = true`)
- Pre-sorted di database level (order, created_at)
- Conditional rendering (tidak render jika tidak ada marquee aktif)

### Styling
- Background: Gradient blue to purple
- Text color: White
- Icon: Font Awesome bullhorn
- Spacing: 8 unit padding antar marquee

## Troubleshooting

### Marquee tidak muncul di landing page
1. Cek apakah ada marquee dengan status **Aktif = ON**
2. Clear browser cache (Ctrl+Shift+R)
3. Verifikasi di database:
   ```bash
   php artisan tinker --execute="echo App\Models\Marquee::active()->get();"
   ```

### Teks terpotong
- Maksimal panjang teks: 500 karakter
- Pastikan teks tidak terlalu panjang agar tetap readable

### Urutan tidak sesuai
- Periksa nilai **Urutan** di admin panel
- Marquee dengan nilai kecil tampil duluan
- Edit marquee untuk mengubah urutan

## Database Query Examples

```php
// Ambil semua marquee aktif dan terurut
$marquees = Marquee::active()->ordered()->get();

// Ambil marquee tertentu
$marquee = Marquee::find(1);

// Create marquee baru
Marquee::create([
    'text' => 'Pengumuman penting',
    'is_active' => true,
    'order' => 0,
]);

// Update marquee
$marquee = Marquee::find(1);
$marquee->update(['is_active' => false]);

// Delete marquee
Marquee::destroy(1);
```

## Migrasi & Seeding

```bash
# Run migration
php artisan migrate

# Seed marquee data
php artisan db:seed --class=MarqueeSeeder

# Atau seed semua
php artisan db:seed
```

## File Structure
```
app/
├── Filament/
│   └── Resources/
│       ├── MarqueeResource.php
│       └── MarqueeResource/
│           └── Pages/
│               ├── CreateMarquee.php
│               ├── EditMarquee.php
│               └── ListMarquees.php
└── Models/
    └── Marquee.php

database/
├── migrations/
│   └── 2025_11_15_000001_create_marquees_table.php
└── seeders/
    └── MarqueeSeeder.php

resources/
└── views/
    └── landing/
        └── layout.blade.php
```

## Integrasi Filament v4
- **Schema-based API**: Form menggunakan `Schema` bukan `Form`
- **Proper Types**: `BackedEnum|string|null` untuk navigationIcon, `UnitEnum|string|null` untuk navigationGroup
- **Components**: Import dari `Filament\Forms\Components` dan `Filament\Schemas\Components`
- **Actions**: Import dari `Filament\Actions` (bukan `Filament\Forms\Actions`)

## Catatan Penting
- Marquee hanya tampil jika ada minimal 1 marquee dengan status **Aktif = ON**
- Animasi pause saat hover untuk memudahkan pembacaan
- Data marquee tidak auto-refresh, perlu reload page untuk melihat perubahan
- Maksimal teks: 500 karakter (enforced di database dan form validation)
