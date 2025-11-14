# 📊 Dokumentasi Fitur Export Data Pendaftar

## Overview

Fitur export data pendaftar memungkinkan admin/TU untuk mengekspor data pendaftar ke format Excel (.xlsx) dengan berbagai opsi filter dan seleksi.

## Teknologi

- **Package**: [Maatwebsite Laravel Excel](https://laravel-excel.com/) v3.1
- **Format Output**: XLSX (Excel 2007+)
- **Engine**: PhpSpreadsheet

## Fitur Export

### 1. Export Semua Data
**Lokasi**: Header Actions di halaman List Applicants

**Cara Menggunakan**:
1. Buka halaman `/admin/applicants`
2. Klik tombol **"Export Excel"** (hijau, icon download)
3. File akan otomatis ter-download

**Filename**: `data-pendaftar-[timestamp].xlsx`
- Contoh: `data-pendaftar-2025-11-14-143022.xlsx`

### 2. Export Berdasarkan Status
**Lokasi**: Header Actions (dengan filter tab aktif)

**Cara Menggunakan**:
1. Klik salah satu tab status:
   - Semua
   - Terdaftar
   - Terverifikasi
   - Diterima
   - Ditolak
   - Registrasi Final
2. Klik tombol **"Export Excel"**
3. Hanya data dengan status tab aktif yang akan di-export

**Filename**: `data-pendaftar-[status]-[timestamp].xlsx`
- Contoh: `data-pendaftar-accepted-2025-11-14-143022.xlsx`

### 3. Export Data Terpilih (Bulk Action)
**Lokasi**: Table Bulk Actions

**Cara Menggunakan**:
1. Centang checkbox pada baris data yang ingin di-export
2. Klik dropdown **"Bulk Actions"** di toolbar table
3. Pilih **"Export Selected"**
4. Checkbox akan otomatis di-uncheck setelah export

**Filename**: `data-pendaftar-selected-[timestamp].xlsx`

## Format Excel

### Header Columns
| No | Kolom | Deskripsi | Width |
|----|-------|-----------|-------|
| A | No. Registrasi | Nomor registrasi unik | 20 |
| B | Nama Lengkap | Nama lengkap pendaftar | 25 |
| C | NISN | Nomor Induk Siswa Nasional | 15 |
| D | Tempat Lahir | Tempat lahir | 20 |
| E | Tanggal Lahir | Format: dd/mm/yyyy | 15 |
| F | Jenis Kelamin | Laki-laki / Perempuan | 15 |
| G | Email | Email pendaftar (opsional) | 25 |
| H | No. HP | Nomor HP pendaftar | 15 |
| I | Nama Orang Tua/Wali | Nama orang tua atau wali | 25 |
| J | No. HP Orang Tua | Nomor HP orang tua | 15 |
| K | Alamat | Alamat lengkap | 35 |
| L | Asal Sekolah | Nama sekolah asal | 30 |
| M | Pilihan Jurusan 1 | Nama jurusan pilihan pertama | 25 |
| N | Pilihan Jurusan 2 | Nama jurusan pilihan kedua | 25 |
| O | Pilihan Jurusan 3 | Nama jurusan pilihan ketiga | 25 |
| P | Jurusan Diterima | Nama jurusan yang diterima | 25 |
| Q | Status | Status pendaftaran | 15 |
| R | Tanggal Daftar | Format: dd/mm/yyyy hh:mm | 20 |

### Styling

**Header Row (Row 1)**:
- Background Color: #4F46E5 (Indigo/Blue)
- Font Color: #FFFFFF (White)
- Font Weight: Bold

**Data Rows**:
- Font: Default
- Auto-width untuk kemudahan membaca
- Text wrapping untuk kolom alamat

### Status Labels (Bahasa Indonesia)
- `registered` → "Terdaftar"
- `verified` → "Terverifikasi"
- `accepted` → "Diterima"
- `rejected` → "Ditolak"
- `registered_final` → "Daftar Ulang"

### Gender Labels
- `male` → "Laki-laki"
- `female` → "Perempuan"

### Nilai Kosong
- Field nullable akan ditampilkan sebagai "-"
- Relationship yang null akan ditampilkan sebagai "-"

## Implementasi Teknis

### Class Export
**File**: `app/Exports/ApplicantsExport.php`

```php
class ApplicantsExport implements 
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithColumnWidths
{
    // Export logic
}
```

### Features Implemented
- `FromCollection`: Mengambil data dari database
- `WithHeadings`: Menentukan header kolom
- `WithMapping`: Transform data sebelum export
- `WithStyles`: Styling untuk header dan cells
- `WithColumnWidths`: Set lebar kolom otomatis

### Query Optimization
```php
// Eager loading relationships untuk performa
Applicant::with([
    'majorChoice1',
    'majorChoice2',
    'majorChoice3',
    'assignedMajor'
])->get();
```

## Kustomisasi

### Menambah Kolom Baru

1. Edit `ApplicantsExport.php`:
```php
// Tambah di method headings()
public function headings(): array
{
    return [
        // ... existing columns
        'Kolom Baru',
    ];
}

// Tambah di method map()
public function map($applicant): array
{
    return [
        // ... existing data
        $applicant->field_baru,
    ];
}

// Tambah di method columnWidths()
public function columnWidths(): array
{
    return [
        // ... existing widths
        'S' => 20, // Kolom baru
    ];
}
```

### Mengubah Styling

Edit method `styles()`:
```php
public function styles(Worksheet $sheet)
{
    return [
        1 => [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'YOUR_COLOR'] // Ganti warna
            ],
        ],
    ];
}
```

### Filter Custom

Di `ListApplicants.php`:
```php
Action::make('export_filtered')
    ->action(function () {
        // Custom filter logic
        $status = 'accepted';
        $major = 'TKJ';
        
        return Excel::download(
            new ApplicantsExport($status, $major),
            'custom-export.xlsx'
        );
    });
```

## Performance Considerations

### Memory Usage
- Untuk data < 1000 rows: Memory usage normal (~50MB)
- Untuk data > 5000 rows: Gunakan chunking

### Chunking untuk Data Besar

```php
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ApplicantsExport implements FromQuery, WithChunkReading
{
    public function query()
    {
        return Applicant::query();
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }
}
```

## Testing

### Manual Testing Checklist
- [ ] Export semua data berhasil
- [ ] Export berdasarkan status berhasil
- [ ] Export selected data berhasil
- [ ] Filename sesuai format
- [ ] Header styling benar
- [ ] Column width sesuai
- [ ] Data mapping benar
- [ ] Relationship data ter-load
- [ ] Status labels dalam Bahasa Indonesia
- [ ] Tanggal format dd/mm/yyyy
- [ ] File dapat dibuka di Excel/Google Sheets

### Automated Testing

```php
// tests/Feature/ExportApplicantsTest.php
public function test_can_export_applicants()
{
    $applicants = Applicant::factory()->count(10)->create();
    
    $response = $this->get(route('applicants.export'));
    
    $response->assertDownload();
    $response->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
}
```

## Troubleshooting

### Issue: File corrupt saat dibuka
**Solution**: Pastikan tidak ada output sebelum download
- Cek tidak ada `dd()`, `dump()`, atau `echo` di controller/export class
- Pastikan tidak ada whitespace di awal file PHP

### Issue: Memory limit exceeded
**Solution**: 
1. Increase memory limit di `.env`: `MEMORY_LIMIT=512M`
2. Atau gunakan chunking untuk data besar

### Issue: Column width tidak sesuai
**Solution**: Adjust di method `columnWidths()` sesuai kebutuhan

### Issue: Relationship data null
**Solution**: Pastikan eager loading di method `collection()`:
```php
return Applicant::with(['majorChoice1', 'majorChoice2', 'majorChoice3', 'assignedMajor'])->get();
```

## Security

### Permission Check
Export hanya dapat diakses oleh user dengan role:
- Admin
- TU (Tata Usaha)

Implementasi di Filament Resource Policy atau Middleware.

### Data Sanitization
- Pastikan tidak ada script injection di data
- Excel akan otomatis escape formula (=, +, -, @)

## Future Enhancements

- [ ] Export ke format PDF
- [ ] Export dengan chart/graph
- [ ] Schedule export otomatis (daily/weekly)
- [ ] Email export results
- [ ] Custom template upload
- [ ] Import from Excel (reverse operation)

---

**Last Updated**: November 14, 2025
**Version**: 1.0.0
