# Sistem PPDB (Penerimaan Peserta Didik Baru)

Sistem manajemen Penerimaan Peserta Didik Baru berbasis web yang dibangun dengan Laravel 12 dan Filament 4.

## 📋 Tentang Proyek

Aplikasi PPDB ini dirancang untuk memudahkan proses pendaftaran siswa baru secara online. Sistem ini menyediakan antarmuka yang user-friendly untuk calon siswa dan panel administrasi yang powerful untuk mengelola seluruh proses PPDB.

## ✨ Fitur Utama

### 🎓 Portal Pendaftaran Publik
- **Formulir Pendaftaran Online**
  - Data pribadi calon siswa (nama, NISN, tempat/tanggal lahir, jenis kelamin)
  - Data kontak (nomor HP, email opsional)
  - Data orang tua/wali (nama dan nomor HP)
  - Data asal sekolah
  - Pemilihan jurusan (pilihan 1, 2, dan 3)
  - Upload dokumen persyaratan (opsional):
    - Foto 3x4
    - Ijazah/STTB
    - Kartu Keluarga
    - Akta Kelahiran
    - Rapor

- **Cek Status Pendaftaran**
  - Cek status menggunakan nomor registrasi
  - Informasi detail status pendaftaran
  - Informasi jurusan yang diterima (jika sudah diterima)

### 🔐 Panel Admin (Filament)
- **Dashboard**
  - Total pendaftar
  - Pendaftar diterima
  - Pendaftar ditolak
  - Statistik real-time

- **Manajemen Pendaftar (Applicants)**
  - View data pendaftar dengan tampilan infolist yang terstruktur
  - Tab-based interface:
    - Data Pribadi
    - Data Orang Tua/Wali
    - Asal Sekolah & Pilihan Jurusan
  - Lihat dokumen yang diupload dengan preview langsung
  - Aksi terima/tolak pendaftar
  - Assign jurusan saat menerima pendaftar
  - Status tracking: Registered → Verified → Accepted/Rejected → Registered Final
  - **Export ke Excel:**
    - Export semua data pendaftar
    - Export berdasarkan tab status aktif
    - Export data terpilih (bulk action)
    - Format Excel dengan styling profesional
    - Nama file otomatis dengan timestamp

- **Manajemen Jurusan (Majors)**
  - CRUD jurusan
  - Set kuota per jurusan
  - Status aktif/nonaktif
  - Tracking jumlah pendaftar per jurusan

- **Pengumuman (Announcements)**
  - Buat dan kelola pengumuman
  - Rich text editor untuk konten
  - Status published/draft
  - Tampilan otomatis di halaman publik

- **Role & Permission**
  - Admin: Akses penuh ke semua fitur
  - TU (Tata Usaha): Kelola data pendaftar dan jurusan
  - Calon Siswa: Akses portal pendaftaran dan cek status

## 🛠️ Teknologi yang Digunakan

- **Laravel 12.38.1** - PHP Framework
- **PHP 8.4.14** - Programming Language
- **Filament 4.0** - Admin Panel
- **MySQL** - Database
- **Spatie Laravel Permission** - Role & Permission Management
- **Maatwebsite Laravel Excel** - Excel Export/Import
- **TailwindCSS** - Styling
- **Vite** - Asset Bundling

## 📦 Instalasi

### Prasyarat
- PHP 8.2 atau lebih tinggi
- Composer
- Node.js & NPM
- MySQL/MariaDB

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone https://github.com/vincent12123/ppdblaravel.git
cd ppdb
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Konfigurasi Environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi Database**
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ppdb
DB_USERNAME=root
DB_PASSWORD=
```

5. **Jalankan Migration & Seeder**
```bash
php artisan migrate --seed
```

6. **Setup Storage**
```bash
php artisan storage:link
```

7. **Build Assets**
```bash
npm run build
```

8. **Jalankan Aplikasi**
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 👤 Default User

Setelah menjalankan seeder, gunakan kredensial berikut untuk login:

**Admin**
- Email: `admin@ppdb.test`
- Password: `password`

**TU (Tata Usaha)**
- Email: `tu@ppdb.test`
- Password: `password`

**Calon Siswa**
- Email: `siswa@ppdb.test`
- Password: `password`

## 📂 Struktur Proyek

```
ppdb/
├── app/
│   ├── Filament/
│   │   ├── Resources/
│   │   │   ├── Applicants/      # Resource pendaftar
│   │   │   ├── Majors/          # Resource jurusan
│   │   │   └── Announcements/   # Resource pengumuman
│   │   └── Widgets/
│   │       └── DocumentVerificationStats.php
│   ├── Http/
│   │   └── Controllers/
│   │       ├── RegistrationController.php
│   │       └── StatusCheckController.php
│   └── Models/
│       ├── Applicant.php
│       ├── Major.php
│       ├── Document.php
│       └── Announcement.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── registration/        # View pendaftaran
│       └── status/             # View cek status
└── routes/
    └── web.php
```

## 🔄 Perubahan & Penyempurnaan

### Fitur yang Ditambahkan
✅ Data orang tua/wali (nama dan nomor HP)
✅ Email menjadi opsional untuk pendaftar
✅ Upload dokumen menjadi opsional
✅ Tampilan infolist terstruktur dengan tabs
✅ Preview dokumen langsung dari panel admin
✅ Status tracking yang jelas
✅ Dashboard dengan statistik lengkap
✅ **Export data pendaftar ke Excel** dengan fitur:
  - Export semua data atau berdasarkan status
  - Export data yang dipilih (bulk action)
  - Format Excel profesional dengan header berwarna
  - Column width otomatis
  - Filename dengan timestamp

### Fitur yang Dihapus
❌ **Documents Resource** - Tidak diperlukan lagi karena dokumen dikelola langsung dari konteks pendaftar
❌ **Field `documents_verified`** - Verifikasi dokumen dihapus karena upload bersifat opsional
❌ **Field `payment_verified`** - Tidak relevan dengan proses PPDB
❌ **Field `rapor_average`** - Dihapus untuk menghindari kebingungan pendaftar
❌ **Tombol Verifikasi Dokumen** - Workflow disederhanakan menjadi terima/tolak pendaftar saja

### Perbaikan Bug
✅ Fixed Filament v4 compatibility (Schema-based API)
✅ Fixed layout issues pada infolist
✅ Fixed major choice menampilkan ID bukan nama jurusan
✅ Fixed HTML rendering pada konten pengumuman
✅ Fixed broken route references setelah penghapusan Documents resource

## 🎯 Alur Kerja Sistem

1. **Calon Siswa** mengisi formulir pendaftaran online
2. **Sistem** generate nomor registrasi otomatis
3. **Calon Siswa** dapat cek status menggunakan nomor registrasi
4. **Admin/TU** melihat data pendaftar di panel admin
5. **Admin/TU** review data dan dokumen pendaftar
6. **Admin/TU** terima atau tolak pendaftar
7. Jika diterima, **Admin/TU** assign jurusan yang sesuai
8. **Calon Siswa** dapat melihat hasil (diterima/ditolak) melalui cek status

## 🗃️ Database Schema

### Applicants (Pendaftar)
- registration_number (unique)
- name, nisn, birth_place, birth_date, gender
- email (nullable), phone
- parent_name, parent_phone
- address, origin_school
- major_choice_1, major_choice_2, major_choice_3
- assigned_major_id (nullable)
- status (registered, verified, accepted, rejected, registered_final)
- registered_at

### Majors (Jurusan)
- name, code, quota, description
- is_active

### Documents (Dokumen)
- applicant_id
- type (foto, ijazah, kartu_keluarga, akta_kelahiran, rapor)
- file_path
- status (pending, verified, rejected)

### Announcements (Pengumuman)
- title, content, published_at, status

## 🚀 Pengembangan Selanjutnya

- [ ] Notifikasi Email/WhatsApp otomatis
- [x] Export data pendaftar (Excel) ✅
- [ ] Import data pendaftar dari Excel
- [ ] Export PDF dengan template custom
- [ ] Sistem pembayaran online
- [ ] Laporan dan analytics lengkap
- [ ] Multi-tahun akademik
- [ ] Cetak formulir pendaftaran
- [ ] Grafik statistik interaktif

## 💡 Cara Menggunakan Fitur Export

### Export Semua Data
1. Masuk ke halaman **Applicants** di panel admin
2. Klik tombol **Export Excel** di pojok kanan atas
3. File akan otomatis ter-download dengan nama `data-pendaftar-[status]-[timestamp].xlsx`

### Export Berdasarkan Status
1. Klik salah satu tab status (Terdaftar, Diterima, Ditolak, dll)
2. Klik tombol **Export Excel**
3. Hanya data dengan status tersebut yang akan di-export

### Export Data Terpilih (Bulk Action)
1. Centang checkbox pada data pendaftar yang ingin di-export
2. Klik dropdown **Bulk Actions** di toolbar
3. Pilih **Export Selected**
4. File akan ter-download dengan nama `data-pendaftar-selected-[timestamp].xlsx`

### Format File Excel
File export berisi kolom-kolom berikut:
- No. Registrasi, Nama Lengkap, NISN
- Tempat & Tanggal Lahir, Jenis Kelamin
- Email, No. HP
- Nama Orang Tua/Wali, No. HP Orang Tua
- Alamat, Asal Sekolah
- Pilihan Jurusan 1, 2, 3
- Jurusan Diterima
- Status, Tanggal Daftar

**Header** dengan background biru dan teks putih, serta **column width** yang sudah disesuaikan untuk kemudahan membaca.

## 📝 Lisensi

Proyek ini adalah open-source software yang dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Developer

Dikembangkan dengan ❤️ menggunakan Laravel & Filament

---

**Catatan**: Sistem ini disederhanakan untuk fokus pada proses inti PPDB. Verifikasi dokumen dan pembayaran dapat ditambahkan kembali sesuai kebutuhan.
