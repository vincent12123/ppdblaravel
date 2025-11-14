# 🚀 Quick Start Guide - Fitur Export

## Persiapan

Pastikan package Laravel Excel sudah terinstall:
```bash
composer require maatwebsite/excel
```

## 3 Cara Export Data Pendaftar

### 1️⃣ Export Semua Data

**Langkah:**
1. Login ke panel admin (`/admin`)
2. Klik menu **Applicants** di sidebar
3. Klik tombol **Export Excel** (hijau) di pojok kanan atas
4. File otomatis ter-download

**Output:** `data-pendaftar-2025-11-14-143022.xlsx`

---

### 2️⃣ Export Berdasarkan Status

**Langkah:**
1. Login ke panel admin
2. Klik menu **Applicants**
3. Pilih tab status yang diinginkan:
   - **Semua** - Export semua pendaftar
   - **Terdaftar** - Export yang baru daftar
   - **Terverifikasi** - Export yang sudah diverifikasi
   - **Diterima** - Export yang diterima
   - **Ditolak** - Export yang ditolak
   - **Registrasi Final** - Export yang sudah daftar ulang
4. Klik tombol **Export Excel**
5. File ter-download dengan nama sesuai status

**Output:** `data-pendaftar-accepted-2025-11-14-143022.xlsx`

---

### 3️⃣ Export Data Terpilih (Custom Selection)

**Langkah:**
1. Login ke panel admin
2. Klik menu **Applicants**
3. **Centang checkbox** pada baris data yang ingin di-export
   - Bisa pilih beberapa atau semua
   - Gunakan checkbox header untuk select all
4. Klik dropdown **Bulk Actions** di toolbar tabel
5. Pilih **Export Selected**
6. File ter-download
7. Checkbox otomatis ter-uncheck

**Output:** `data-pendaftar-selected-2025-11-14-143022.xlsx`

---

## Isi File Excel

File yang di-export berisi kolom-kolom berikut:

### Kolom Data Pribadi
- No. Registrasi (contoh: `PPDB-2025-001`)
- Nama Lengkap
- NISN
- Tempat Lahir
- Tanggal Lahir (format: `14/11/2025`)
- Jenis Kelamin (`Laki-laki` / `Perempuan`)

### Kolom Kontak
- Email (jika ada, jika tidak: `-`)
- No. HP
- Nama Orang Tua/Wali
- No. HP Orang Tua

### Kolom Sekolah & Jurusan
- Alamat
- Asal Sekolah
- Pilihan Jurusan 1
- Pilihan Jurusan 2
- Pilihan Jurusan 3
- Jurusan Diterima (jika sudah diterima)

### Kolom Status
- Status (`Terdaftar`, `Diterima`, `Ditolak`, dll)
- Tanggal Daftar (format: `14/11/2025 14:30`)

---

## Tampilan Excel

### Header
- **Background**: Biru (#4F46E5)
- **Text**: Putih, Bold
- **Height**: Auto-adjusted

### Data Cells
- **Width**: Auto-adjusted untuk setiap kolom
- **Alignment**: Left untuk text, Center untuk tanggal
- **Format**: Clean & professional

---

## Tips & Tricks

### 📌 Filter Sebelum Export
Gunakan filter di tabel sebelum export untuk hasil yang lebih spesifik:
- Filter by status
- Filter by jurusan pilihan
- Filter by jurusan diterima
- Search by nama/NISN

### 📌 Sort Data
Klik header kolom untuk sort data sebelum export:
- Sort by tanggal daftar (terbaru/terlama)
- Sort by nama (A-Z)
- Sort by status

### 📌 Column Visibility
Toggle kolom yang tidak perlu di-hide dulu sebelum export untuk hasil yang lebih ringkas.

### 📌 Bulk Operations
Untuk export data spesifik:
1. Gunakan filter untuk mempersempit data
2. Centang hanya yang diperlukan
3. Export selected

---

## Contoh Use Cases

### Case 1: Export Semua Pendaftar yang Diterima
1. Klik tab **Diterima**
2. Klik **Export Excel**
3. Done! ✅

### Case 2: Export Pendaftar TKJ yang Diterima
1. Gunakan filter **Jurusan Diterima** → Pilih `TKJ`
2. Klik **Export Excel**
3. File berisi hanya pendaftar TKJ yang diterima

### Case 3: Export 10 Pendaftar Tertentu
1. Cari dan centang 10 pendaftar yang dimaksud
2. Klik **Bulk Actions** → **Export Selected**
3. File berisi 10 data tersebut

### Case 4: Export untuk Laporan Bulanan
1. Buka halaman **Applicants**
2. Filter by tanggal (menggunakan filter custom jika ada)
3. Klik **Export Excel**
4. Gunakan file untuk laporan

---

## Troubleshooting

### ❌ File Tidak Ter-Download
**Solusi:**
- Cek popup blocker browser
- Cek permission browser untuk download
- Coba browser lain

### ❌ File Corrupt / Tidak Bisa Dibuka
**Solusi:**
- Pastikan menggunakan Excel 2007 atau lebih baru
- Atau buka dengan Google Sheets
- Cek apakah download complete (file size > 0)

### ❌ Data Tidak Lengkap
**Solusi:**
- Pastikan data sudah ter-load semua di tabel
- Coba refresh halaman
- Cek apakah ada filter aktif

### ❌ Export Lama / Loading
**Solusi:**
- Normal untuk data > 1000 rows
- Tunggu hingga download complete
- Atau export per batch menggunakan filter

---

## FAQ

**Q: Apakah bisa export ke PDF?**
A: Saat ini hanya support Excel. PDF sedang dalam development.

**Q: Berapa maksimal data yang bisa di-export?**
A: Tidak ada limit, tapi disarankan < 10,000 rows untuk performa optimal.

**Q: Apakah bisa custom kolom yang di-export?**
A: Ya, bisa dimodifikasi di file `ApplicantsExport.php`.

**Q: Apakah ada log export?**
A: Saat ini belum ada. Bisa ditambahkan dengan logging custom.

**Q: Siapa saja yang bisa export?**
A: Hanya user dengan role `admin` dan `tu`.

**Q: Apakah data di-export real-time?**
A: Ya, data yang di-export adalah data terbaru saat tombol export diklik.

---

## Video Tutorial

_(Coming soon)_

---

**Butuh bantuan?** Hubungi admin sistem atau baca dokumentasi lengkap di `docs/EXPORT_FEATURE.md`.

**Last Updated**: November 14, 2025
