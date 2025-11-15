# Fitur Pengaturan Sekolah - Dokumentasi

## Deskripsi
Fitur Pengaturan Sekolah memungkinkan admin untuk mengelola informasi identitas sekolah secara terpusat dari dashboard admin. Data yang dikelola akan otomatis ditampilkan di footer website landing page dan bagian lainnya.

## Komponen

### 1. Halaman Admin (Filament)
**File**: `app/Filament/Pages/SchoolSettings.php`

**Lokasi Menu**: Navigasi group "Pengaturan" → "Pengaturan Sekolah"

**Sections**:
1. **Informasi Umum Sekolah**
   - Nama Sekolah (required)
   - Email Sekolah (required, email format)
   - Nomor Telepon (required)
   - Website (URL format)
   - Deskripsi Sekolah (max 500 karakter)

2. **Alamat Sekolah**
   - Alamat Lengkap (required)
   - Kota/Kabupaten (required)
   - Provinsi (required)
   - Kode Pos

3. **Media Sosial**
   - Facebook (URL)
   - Instagram (URL)
   - YouTube (URL)
   - WhatsApp (format: 628xxx tanpa +)

### 2. Penyimpanan Data
**Tabel**: `settings`
**Model**: `App\Models\Setting`

**Setting Keys**:
- `school_name`: Nama sekolah
- `school_email`: Email sekolah
- `school_phone`: Nomor telepon
- `school_website`: URL website sekolah
- `school_description`: Deskripsi singkat sekolah
- `school_address`: Alamat lengkap
- `school_city`: Kota/Kabupaten
- `school_province`: Provinsi
- `school_postal_code`: Kode pos
- `school_facebook`: URL Facebook
- `school_instagram`: URL Instagram
- `school_youtube`: URL YouTube
- `school_whatsapp`: Nomor WhatsApp (format 628xxx)

### 3. Tampilan Frontend
**File**: `resources/views/landing/partials/footer.blade.php`

**Implementasi**:
```blade
@php
    use App\Models\Setting;
    $schoolName = Setting::get('school_name', 'SMK Negeri 1');
    $schoolDesc = Setting::get('school_description', '...');
    // ... dst
@endphp

<footer>
    <h3>PPDB {{ $schoolName }}</h3>
    <p>{{ $schoolDesc }}</p>
    <!-- Data lainnya -->
</footer>
```

**Data yang Ditampilkan**:
- Nama sekolah di header footer
- Deskripsi sekolah
- Kontak (telepon, email, alamat)
- Link media sosial (hanya tampil jika diisi)

### 4. Seeder
**File**: `database/seeders/SettingSeeder.php`

**Default Values**:
```php
'school_name' => 'SMK Negeri 1',
'school_address' => 'Jl. Pendidikan No. 123',
'school_city' => 'Jakarta',
'school_province' => 'DKI Jakarta',
'school_postal_code' => '12345',
'school_phone' => '(021) 1234-5678',
'school_email' => 'ppdb@smk.sch.id',
'school_website' => 'https://smk.sch.id',
'school_description' => 'Sistem Penerimaan Peserta Didik Baru online...',
```

## Cara Menggunakan

### Mengubah Informasi Sekolah

1. Login ke dashboard admin
2. Navigasi ke menu **Pengaturan** → **Pengaturan Sekolah**
3. Edit field yang ingin diubah:
   - **Informasi Umum**: Nama, email, telepon, website, deskripsi
   - **Alamat**: Alamat lengkap, kota, provinsi, kode pos
   - **Media Sosial**: Link Facebook, Instagram, YouTube, WhatsApp
4. Klik tombol **Simpan Pengaturan**
5. Data akan langsung muncul di footer website

### Validasi Field

#### Field Wajib (Required):
- Nama Sekolah
- Email Sekolah
- Nomor Telepon
- Alamat Lengkap
- Kota/Kabupaten
- Provinsi

#### Field Opsional:
- Website
- Kode Pos
- Semua link media sosial

#### Format Khusus:
- **Email**: Harus format email valid (contoh@domain.com)
- **Website**: Harus format URL (https://...)
- **Media Sosial**: Harus format URL lengkap (https://...)
- **WhatsApp**: Format nomor 628xxx (tanpa tanda +)

### Mengatur Media Sosial

**Facebook**:
- Format: `https://facebook.com/namahalaman`
- Contoh: `https://facebook.com/smknegeri1`

**Instagram**:
- Format: `https://instagram.com/username`
- Contoh: `https://instagram.com/smknegeri1`

**YouTube**:
- Format: `https://youtube.com/@channel`
- Contoh: `https://youtube.com/@smknegeri1`

**WhatsApp**:
- Format: `628123456789` (tanpa tanda +, spasi, atau tanda hubung)
- Contoh: `6281234567890`
- Link otomatis dibuat: `https://wa.me/628123456789`

**Catatan**: Jika link media sosial tidak diisi, icon tidak akan ditampilkan di footer.

## Fitur Teknis

### Caching
- Data settings menggunakan caching 300 detik (5 menit)
- Defined di `App\Models\Setting::get()` method
- Cache key: `setting.{key}`
- Cache otomatis clear saat data di-update

### Database Query
```php
// Ambil nilai setting
$schoolName = Setting::get('school_name', 'Default Value');

// Set nilai setting
Setting::set('school_name', 'SMK Baru');

// Cek apakah setting exists
if (Setting::has('school_name')) {
    // ...
}
```

### Conditional Rendering di Footer
```blade
@if($schoolFacebook)
    <a href="{{ $schoolFacebook }}" target="_blank">
        <i class="fab fa-facebook"></i>
    </a>
@endif
```

Hanya media sosial yang diisi yang akan ditampilkan di footer.

## Troubleshooting

### Data tidak muncul di footer
1. Clear cache aplikasi:
   ```bash
   php artisan cache:clear
   ```
2. Verifikasi data di database:
   ```bash
   php artisan tinker --execute="echo App\Models\Setting::where('key', 'LIKE', 'school_%')->get();"
   ```
3. Pastikan footer blade sudah di-update dengan kode yang benar

### Form tidak bisa disimpan
1. Cek validasi field required
2. Pastikan format email dan URL valid
3. Cek error di browser console (F12)
4. Cek log Laravel: `storage/logs/laravel.log`

### Icon media sosial tidak muncul
- Pastikan Font Awesome sudah di-load di layout.blade.php
- Cek apakah URL sudah diisi di halaman settings
- Cek browser console untuk error loading icon

### WhatsApp link tidak bekerja
- Format harus: `628123456789` (tanpa +, spasi, atau tanda hubung)
- Pastikan nomor dimulai dengan `62` (kode Indonesia)
- Link akan otomatis dibuat: `https://wa.me/628123456789`

## Best Practices

### Penamaan dan Branding
1. Gunakan nama resmi sekolah (sesuai SK pendirian)
2. Deskripsi singkat tapi informatif (max 500 karakter)
3. Email gunakan domain resmi sekolah jika ada

### Kontak
1. Nomor telepon gunakan format dengan kurung: `(021) 1234-5678`
2. Email khusus untuk PPDB lebih baik (contoh: ppdb@...)
3. Alamat lengkap dengan nomor jalan dan landmark

### Media Sosial
1. Gunakan akun resmi sekolah
2. Pastikan link aktif dan tidak broken
3. Update link jika akun berubah
4. Kosongkan field jika akun tidak ada (lebih baik daripada link dummy)

### Maintenance
1. Review data sekolah setiap awal tahun ajaran
2. Update nomor kontak jika berubah
3. Test semua link media sosial secara berkala
4. Backup settings sebelum mengubah data penting

## Integrasi dengan Fitur Lain

### Footer Website
- Data otomatis tampil di `resources/views/landing/partials/footer.blade.php`
- Nama sekolah di header footer
- Kontak lengkap di section "Kontak"
- Icon media sosial di section "Ikuti Kami"
- Copyright dengan nama sekolah

### Potensi Pengembangan
- [ ] Tampilkan nama sekolah di navbar
- [ ] Tampilkan logo sekolah (upload file)
- [ ] Tampilkan info sekolah di halaman About Us
- [ ] Export settings ke JSON untuk backup
- [ ] Multi-bahasa untuk deskripsi
- [ ] Integrasi Google Maps untuk alamat
- [ ] Jam operasional sekolah
- [ ] Visi dan Misi sekolah

## Database Schema

```sql
-- Table: settings
CREATE TABLE settings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(255) NOT NULL UNIQUE,
    value TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Indexes
CREATE UNIQUE INDEX settings_key_unique ON settings(`key`);
```

## Seeding Data

```bash
# Seed semua settings termasuk school settings
php artisan db:seed --class=SettingSeeder

# Atau seed semua
php artisan db:seed

# Fresh migration + seed
php artisan migrate:fresh --seed
```

## File Structure
```
app/
├── Filament/
│   └── Pages/
│       └── SchoolSettings.php          # Admin page
└── Models/
    └── Setting.php                     # Model dengan get/set methods

database/
└── seeders/
    └── SettingSeeder.php               # Default values

resources/
└── views/
    ├── filament/
    │   └── pages/
    │       └── school-settings.blade.php   # Page view
    └── landing/
        └── partials/
            └── footer.blade.php            # Display settings
```

## Security Notes

1. **Access Control**: Hanya admin yang bisa mengakses halaman settings
2. **Validation**: Semua input di-validasi (email, URL, required fields)
3. **XSS Protection**: Laravel Blade otomatis escape output `{{ }}`
4. **SQL Injection**: Eloquent ORM melindungi dari SQL injection
5. **Cache**: Sensitive data (jika ada) tidak di-cache terlalu lama

## Performance

- **Caching**: 5 menit cache untuk semua settings
- **Query Optimization**: Setting::get() hanya 1 query per key
- **Lazy Loading**: Footer hanya load data yang diperlukan
- **Conditional Rendering**: Tidak render element jika data kosong

## Changelog

**v1.0 (15 November 2025)**
- ✅ Created SchoolSettings page di Filament
- ✅ 13 field settings (info umum, alamat, media sosial)
- ✅ Dynamic footer dengan data dari database
- ✅ Seeder dengan default values
- ✅ Form validation dan error handling
- ✅ Success notification setelah save
- ✅ Conditional rendering untuk media sosial
- ✅ Cache support untuk performa

## Support

Jika ada pertanyaan atau issue:
1. Cek log: `storage/logs/laravel.log`
2. Cek database: Tabel `settings` dengan key `school_*`
3. Test form validation di halaman settings
4. Verify data muncul di footer landing page
