
## Fitur Utama Sistem

**Halaman Depan (Landing Page)**

- Hero section dengan showcase 3 jurusan (Perhotelan, Teknik Sepeda Motor, RPL) dengan foto dan deskripsi singkat[^4]
- Informasi jadwal PPDB, alur pendaftaran, dan persyaratan
- Call-to-action button "Daftar Sekarang" yang prominent[^4]
- Virtual tour atau galeri kegiatan per jurusan

**Formulir Pendaftaran Online**

- Data pribadi calon siswa (biodata, alamat, kontak)
- Upload dokumen digital (ijazah, KK, KTP, foto, rapor)
- **Pilihan jurusan prioritas** (pilihan 1, 2, 3) dengan deskripsi singkat per jurusan[^2]
- Validasi data otomatis untuk mengurangi error input[^3][^2]
- Generate nomor pendaftaran otomatis setelah submit

**Dashboard Admin/Panitia**

- Monitoring jumlah pendaftar real-time per jurusan[^1]
- Verifikasi dokumen dan status pembayaran[^2][^3]
- Sistem seleksi otomatis berdasarkan kriteria (nilai rapor, kuota per jurusan)[^1]
- Export laporan Excel/PDF untuk analisis data[^1]
- Manajemen pengumuman dan jadwal tes

**Portal Calon Siswa**

- Cek status pendaftaran dengan nomor registrasi
- Cetak kartu ujian/bukti pendaftaran[^3]
- Notifikasi via email/WhatsApp untuk update status
- Panduan persiapan tes per jurusan


## Teknologi yang Disarankan

**Backend**: Laravel dengan Filament 4 admin panel (sesuai stack Anda) 
**Frontend**: Tailwind CSS + Bootstrap 5 untuk responsive design[^3]
**Database**: MySQL untuk menyimpan data pendaftar
**Storage**: local storage untuk dokumen upload
**Security**: SSL encryption, CAPTCHA, dan role-based access[^1]

## Fitur Khusus per Jurusan

**Perhotelan**: Informasi praktik kerja di hotel partner, sertifikasi kompetensi
**Teknik Sepeda Motor**: Showcase workshop dan fasilitas praktikum mesin[^5]
**RPL**: Portfolio project siswa, lab komputer, dan jalur karir IT[^6]

## Alur Pendaftaran

1. Calon siswa registrasi dan pilih jurusan prioritas
2. Upload dokumen dan bayar biaya pendaftaran
3. Sistem verifikasi otomatis oleh admin
4. Pengumuman hasil seleksi dengan pembagian per jurusan
5. Daftar ulang online untuk yang diterima



