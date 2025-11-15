# Fitur Chatbot PPDB (Gemini)

## Ringkas Fitur
Chatbot membantu pengunjung menanyakan hal seputar PPDB (jadwal, persyaratan, jurusan, cara daftar). Jawaban diproses oleh model Gemini melalui backend Laravel (proxy) agar API Key aman.

## Enable / Disable
Visibilitas chatbot di landing page dikendalikan oleh setting:
- `gemini_enabled` (tabel `settings`)
- Jika bernilai `'true'` maka widget tampil.
- Jika `'false'`, widget tidak di-include (Blade conditional) dan jika ter-cache, JavaScript guard akan menghapus widget.

## Settings Page (Filament)
Halaman: Pengaturan → Pengaturan Chatbot (Gemini)
Field:
- Aktifkan Chatbot (Toggle)
- Gemini API Key (TextInput password revealable)
- Model (Select: `gemini-1.5-flash` / `gemini-1.5-pro`)
- Instruksi Sistem (Textarea)

## System Instruction Default
Menjaga fokus jawaban hanya pada topik PPDB. Tersimpan di key `gemini_system_instruction` dan bisa diedit.

## Arsitektur
1. Frontend mengirim pertanyaan via fetch POST ke route `chat.ai`.
2. Controller `ChatbotController` membangun payload + system instruction.
3. Mengirim request ke endpoint Gemini REST API.
4. Jawaban markdown dikonversi menjadi HTML sederhana (bold, italic, newline).
5. Response JSON `{ reply: '<html>' }` dikirim balik ke frontend.

## Endpoint
Route: `POST /chat-ai` name: `chat.ai`
Proteksi: CSRF token dipasang di `<meta name="csrf-token">` pada layout.

## Kunci Setting yang Dipakai
| Key | Deskripsi |
|-----|-----------|
| gemini_enabled | true/false aktifkan widget |
| gemini_api_key | API key Gemini (disimpan di DB) |
| gemini_model | Nama model (default flash) |
| gemini_system_instruction | Batasan jawaban |

## Cara Aktifkan
1. Buka halaman Pengaturan Chatbot.
2. Isi API Key dari Google AI Studio.
3. Pilih model.
4. Pastikan toggle aktif.
5. Simpan.
6. Refresh landing page.

## Cara Nonaktifkan
1. Buka halaman Pengaturan Chatbot.
2. Matikan toggle.
3. Simpan.
4. Refresh landing page (widget hilang).

## Error Handling
- Jika model/API tidak tersedia: balasan fallback “Asisten AI sibuk / gangguan”.
- Jika disabled atau api key kosong: status 503 + pesan bahwa asisten belum diaktifkan.
- Timeout: 15 detik.

## Keamanan
- API Key tidak muncul di client (hanya server side).
- Jawaban di-escape lalu markdown dasar ditransform.
- CSRF di semua request.

## Performa
- Output tokens dibatasi 512.
- Model flash untuk respon cepat.
- Temperatur 0.4 agar jawaban konsisten.

## Pengembangan Lanjutan (Opsional)
- Logging percakapan (tanpa data sensitif) untuk analitik.
- Rate limiting (misal per IP) untuk mencegah spam.
- Penyaringan kata kunci tambahan sebelum kirim ke model.
- Tombol "Tes Prompt" di halaman pengaturan.
- Dukungan multi-bahasa (Indonesia / Inggris).

## Contoh Fetch (Manual)
```js
fetch('/chat-ai', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
  },
  body: JSON.stringify({ message: 'Apa jadwal PPDB?' })
}).then(r => r.json()).then(console.log);
```

## Blok Kode Utama
Controller: `app/Http/Controllers/ChatbotController.php`
Settings Page: `app/Filament/Pages/ChatbotSettings.php`
Widget Blade: `resources/views/landing/partials/chatbot.blade.php`
Conditional Include: `resources/views/landing/layout.blade.php`
Seeder: `database/seeders/SettingSeeder.php`

## Troubleshooting
| Masalah | Solusi |
|---------|--------|
| Widget tidak tampil | Pastikan `gemini_enabled = true` di DB / halaman pengaturan |
| Balasan selalu fallback | Cek API Key valid & model tersedia |
| Error 503 | Chatbot dinonaktifkan atau API key kosong |
| CSRF error | Pastikan meta csrf ada di layout dan fetch header benar |
| Jawaban panjang/lambat | Turunkan maxOutputTokens atau gunakan model flash |

## Changelog
v1.0 - Implementasi dasar chatbot PPDB dengan enable/disable toggle.
