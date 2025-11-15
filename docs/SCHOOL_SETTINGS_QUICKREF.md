# Quick Reference: Pengaturan Sekolah

## Akses Halaman
**Menu**: Pengaturan → Pengaturan Sekolah

## Field Summary

### ✅ Required Fields
| Field | Format | Contoh |
|-------|--------|--------|
| Nama Sekolah | Text (max 255) | SMK Negeri 1 Jakarta |
| Email Sekolah | Email | ppdb@smk.sch.id |
| Nomor Telepon | Tel (max 20) | (021) 1234-5678 |
| Alamat Lengkap | Textarea (max 500) | Jl. Pendidikan No. 123 |
| Kota/Kabupaten | Text (max 100) | Jakarta Selatan |
| Provinsi | Text (max 100) | DKI Jakarta |

### ⚪ Optional Fields
| Field | Format | Contoh |
|-------|--------|--------|
| Website | URL | https://smk.sch.id |
| Kode Pos | Text (max 10) | 12345 |
| Deskripsi | Textarea (max 500) | SMK terbaik di Jakarta... |
| Facebook | URL | https://facebook.com/smk |
| Instagram | URL | https://instagram.com/smk |
| YouTube | URL | https://youtube.com/@smk |
| WhatsApp | Number | 628123456789 |

## Default Values (Seeder)
```bash
php artisan db:seed --class=SettingSeeder
```

Default data:
- Nama: SMK Negeri 1
- Alamat: Jl. Pendidikan No. 123
- Kota: Jakarta
- Provinsi: DKI Jakarta
- Kode Pos: 12345
- Telepon: (021) 1234-5678
- Email: ppdb@smk.sch.id
- Website: https://smk.sch.id

## Database Keys
Settings disimpan di tabel `settings` dengan key:
- `school_name`
- `school_email`
- `school_phone`
- `school_website`
- `school_description`
- `school_address`
- `school_city`
- `school_province`
- `school_postal_code`
- `school_facebook`
- `school_instagram`
- `school_youtube`
- `school_whatsapp`

## Query via Code
```php
use App\Models\Setting;

// Get value
$name = Setting::get('school_name', 'Default');

// Set value
Setting::set('school_name', 'SMK Baru');

// Check exists
if (Setting::has('school_name')) {
    // ...
}
```

## Display di Frontend
Footer otomatis menggunakan data dari settings:
- Nama di header footer: `PPDB {{ $schoolName }}`
- Kontak section
- Media sosial icons (conditional)

## Troubleshooting

### Form tidak muncul
```bash
php artisan cache:clear
php artisan config:clear
```

### Data tidak tersimpan
- Cek validasi field required
- Cek format email & URL
- Cek log: `storage/logs/laravel.log`

### Footer tidak update
```bash
php artisan cache:clear
```

### Verify data di database
```bash
php artisan tinker --execute="echo App\Models\Setting::where('key', 'LIKE', 'school_%')->get();"
```

## Tips
✅ Gunakan nama resmi sekolah  
✅ Email khusus PPDB lebih baik  
✅ Format telepon dengan kurung: (021) xxx-xxxx  
✅ WhatsApp format: 628xxx (tanpa +)  
✅ Kosongkan media sosial jika tidak ada (jangan isi #)  
✅ Deskripsi singkat tapi informatif (max 500 char)  

## Update Workflow
1. Login admin panel
2. Buka Pengaturan → Pengaturan Sekolah
3. Edit field yang diperlukan
4. Klik "Simpan Pengaturan"
5. Verifikasi di footer landing page
6. ✅ Done!

## Cache Behavior
- Cache duration: 5 menit (300 detik)
- Auto clear saat save
- Manual clear: `php artisan cache:clear`
