Tentu, ini adalah ide yang sangat bagus. Anda ingin mengganti logika `faqDatabase` yang statis di JavaScript dengan kecerdasan Gemini AI, namun **membatasinya** agar hanya menjawab seputar PPDB.

Ini adalah arsitektur yang tepat. Kita tidak bisa memanggil API Gemini langsung dari JavaScript di *browser* karena itu akan membocorkan Kunci API (API Key) Anda.

Strategi yang benar adalah:

1.  **Frontend (JavaScript):** Tetap seperti kode Anda, tapi alih-alih mencari di `faqDatabase`, ia akan mengirimkan pertanyaan pengguna ke backend Laravel Anda.
2.  **Backend (Laravel):** Menerima pertanyaan, lalu secara aman memanggil Gemini API dengan **instruksi sistem (system instruction)** yang sangat spesifik.
3.  **Gemini AI:** Menerima pertanyaan + instruksi (misal: "Kamu adalah asisten PPDB, jangan jawab hal lain").
4.  **Backend (Laravel):** Menerima jawaban dari Gemini dan mengirimkannya kembali ke Frontend.
5.  **Frontend (JavaScript):** Menampilkan jawaban dari AI di kotak chat.

Berikut adalah langkah-langkah lengkap untuk mengintegrasikannya ke dalam kode yang Anda berikan, menggunakan Laravel (sesuai dengan tag `{{ route(...) }}` pada kode Anda).

-----

### Langkah 1: Siapkan Backend (Laravel)

Pertama, kita siapkan *controller* dan *route* di Laravel yang akan bertindak sebagai jembatan aman ke Gemini AI.

#### 1\. Instal Paket Gemini PHP

Di terminal proyek Laravel Anda, jalankan:

```bash
composer require google/generative-ai
```

#### 2\. Tambahkan API Key ke `.env`

Dapatkan API Key Anda dari [Google AI Studio](https://aistudio.google.com/app/apikey) dan tambahkan ke file `.env` Anda:

```ini
GEMINI_API_KEY=xxxxxxxxxxxxxxxxxxxxxxxxxxx
```

#### 3\. Buat Route

Tambahkan *route* baru ini di file `routes/web.php` atau `routes/api.php` Anda. Saya sarankan di `web.php` agar mendapat proteksi CSRF.

```php
// routes/web.php
use App\Http\Controllers\ChatbotController;

Route::post('/chat-ai', [ChatbotController::class, 'handleChat'])->name('chat.ai');
```

#### 4\. Buat Controller

Jalankan perintah ini untuk membuat *controller* baru:

```bash
php artisan make:controller ChatbotController
```

Buka file `app/Http/Controllers/ChatbotController.php` dan isi dengan kode berikut. **Perhatikan bagian `systemInstruction`**, ini adalah kunci untuk membatasi jawaban AI.

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\GenerativeAI\GenerativeModel;
use Google\GenerativeAI\Content;
use Google\GenerativeAI\Part;

class ChatbotController extends Controller
{
    /**
     * Menangani permintaan chat dari widget.
     */
    public function handleChat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $userMessage = $request->input('message');
        $apiKey = env('GEMINI_API_KEY');

        try {
            // *** INI ADALAH KUNCINYA ***
            // Instruksi sistem untuk membatasi AI
            $systemInstruction = Content::text(
                "Anda adalah asisten virtual untuk PPDB (Penerimaan Peserta Didik Baru) sebuah sekolah. ".
                "Tugas Anda adalah menjawab pertanyaan yang *hanya* berhubungan dengan pendaftaran sekolah, ".
                "seperti: jadwal pendaftaran, persyaratan dokumen, biaya, jurusan yang tersedia, dan cara mendaftar. ".
                "Jika ada pertanyaan di luar topik PPDB (misalnya tentang cuaca, politik, matematika, atau pengetahuan umum), ".
                "Anda *harus* menolak menjawab dengan sopan dan mengarahkan pengguna kembali ke topik PPDB. ".
                "Contoh penolakan: 'Maaf, saya hanya bisa membantu pertanyaan seputar PPDB sekolah ini.' ".
                "Jawablah dengan ramah, singkat, dan jelas."
            );

            // Inisialisasi model Gemini
            $model = new GenerativeModel(
                'gemini-1.5-flash-latest', // Gunakan model flash untuk respon cepat
                $apiKey,
                null, // Safety Settings
                $systemInstruction // Terapkan instruksi sistem
            );

            // Mulai sesi chat (opsional, tapi baik untuk konteks)
            $chat = $model->startChat();
            
            // Kirim pesan pengguna
            $response = $chat->sendMessage(Content::text($userMessage));

            // Konversi jawaban AI (Markdown) ke HTML
            $botReply = $this->convertMarkdownToHtml($response->text());

            return response()->json(['reply' => $botReply]);

        } catch (\Exception $e) {
            // Tangani error jika API gagal
            report($e); // Laporkan error
            return response()->json(
                ['reply' => 'Maaf, asisten AI kami sedang mengalami gangguan. Silakan coba lagi nanti.'],
                500
            );
        }
    }

    /**
     * Helper sederhana untuk konversi Markdown ke HTML.
     * Gemini sering membalas dengan Markdown (misal **bold**).
     */
    private function convertMarkdownToHtml(string $text): string
    {
        // 1. Escape HTML dasar untuk keamanan
        $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
        
        // 2. Konversi **bold** -> <strong>bold</strong>
        $text = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $text);
        
        // 3. Konversi *italic* -> <em>italic</em>
        $text = preg_replace('/\*(.*?)\*/s', '<em>$1</em>', $text);
        
        // 4. Konversi baris baru -> <br>
        $text = nl2br($text);
        
        return $text;
    }
}
```

-----

### Langkah 2: Modifikasi Frontend (HTML & JavaScript)

Sekarang, kita ubah kode JavaScript Anda untuk memanggil backend Laravel yang baru saja kita buat.

#### 1\. Tambahkan CSRF Token (PENTING)

Di dalam tag `<head>` file layout Blade utama Anda (misal: `app.blade.php`), pastikan Anda memiliki *meta tag* ini. Laravel membutuhkannya untuk `fetch` POST.

```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

#### 2\. Ganti Kode `<script>` Anda

Ganti seluruh blok `<script>` Anda dengan yang ada di bawah ini. Saya telah menghapus `faqDatabase` dan mengganti `getBotResponse` dengan fungsi `getAiResponse` baru yang memanggil backend.

```javascript
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('chatbot-toggle');
    const closeBtn = document.getElementById('chatbot-close');
    const widget = document.getElementById('chatbot-widget');
    const chatIcon = document.getElementById('chat-icon');
    const closeIcon = document.getElementById('close-icon');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');
    const quickReplyBtns = document.querySelectorAll('.quick-reply-btn');
    const chatAiUrl = "{{ route('chat.ai') }}"; // Ambil URL dari Laravel
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Toggle chatbot
    function toggleChatbot() {
        widget.classList.toggle('hidden');
        chatIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
        
        if (!widget.classList.contains('hidden')) {
            chatInput.focus();
            document.getElementById('unread-badge').classList.add('hidden');
        }
    }

    toggleBtn.addEventListener('click', toggleChatbot);
    closeBtn.addEventListener('click', toggleChatbot);

    // Add message to chat
    function addMessage(text, isUser = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `flex items-start space-x-2 animate-fade-in ${isUser ? 'justify-end' : ''}`;
        
        if (isUser) {
            messageDiv.innerHTML = `
                <div class="bg-green-500 text-white rounded-2xl rounded-tr-none p-3 shadow-sm max-w-[80%]">
                    <p class="text-sm">${escapeHtml(text)}</p>
                </div>
            `;
        } else {
            messageDiv.innerHTML = `
                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-robot text-white text-xs"></i>
                </div>
                <div class="bg-white rounded-2xl rounded-tl-none p-3 shadow-sm max-w-[80%]">
                    <p class="text-sm text-gray-800">${text}</p> </div>
            `;
        }
        
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Show typing indicator
    function showTypingIndicator() {
        const typingDiv = document.createElement('div');
        typingDiv.id = 'typing-indicator';
        typingDiv.className = 'flex items-start space-x-2';
        typingDiv.innerHTML = `
            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-robot text-white text-xs"></i>
            </div>
            <div class="bg-white rounded-2xl rounded-tl-none p-3 shadow-sm">
                <div class="typing-indicator">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        `;
        chatMessages.appendChild(typingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function removeTypingIndicator() {
        const typingIndicator = document.getElementById('typing-indicator');
        if (typingIndicator) {
            typingIndicator.remove();
        }
    }

    // *** FUNGSI BARU UNTUK MEMANGGIL AI BACKEND ***
    async function getAiResponse(userMessage) {
        try {
            const response = await fetch(chatAiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: userMessage })
            });

            if (!response.ok) {
                // Jika server error (500, dll)
                const errorData = await response.json();
                return errorData.reply || "Maaf, terjadi kesalahan koneksi ke asisten AI.";
            }

            const data = await response.json();
            return data.reply; // Ini adalah jawaban dari Gemini (sudah format HTML)

        } catch (error) {
            console.error('Chatbot error:', error);
            return "Maaf, saya tidak dapat terhubung ke server. Periksa koneksi internet Anda.";
        }
    }

    // *** FUNGSI getBotResponse() dan faqDatabase SUDAH DIHAPUS ***

    // Handle form submission (dibuat async)
    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const userMessage = chatInput.value.trim();
        if (!userMessage) return;
        
        addMessage(userMessage, true);
        chatInput.value = '';
        showTypingIndicator();
        
        // Panggil AI dan tunggu jawaban
        const botResponse = await getAiResponse(userMessage);
        
        removeTypingIndicator();
        addMessage(botResponse, false);
    });

    // Handle quick reply buttons (dibuat async)
    quickReplyBtns.forEach(btn => {
        btn.addEventListener('click', async function() {
            const question = this.dataset.question;
            addMessage(question, true);
            showTypingIndicator();
            
            // Panggil AI dan tunggu jawaban
            const botResponse = await getAiResponse(question);
            
            removeTypingIndicator();
            addMessage(botResponse, false);
        });
    });

    // Escape HTML (tetap dipakai untuk pesan user)
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Show notification after page load
    setTimeout(function() {
        if (widget.classList.contains('hidden')) {
            document.getElementById('unread-badge').classList.remove('hidden');
        }
    }, 3000);
});
</script>
```

Dengan ini, chatbot Anda sekarang ditenagai oleh Gemini dan akan secara otomatis menolak untuk menjawab pertanyaan di luar topik PPDB, persis seperti yang Anda inginkan.
