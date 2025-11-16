<!-- Floating Chatbot Widget -->
<div id="chatbot-container" class="fixed bottom-6 right-6 z-50">
    <!-- Chat Button -->
    <button id="chatbot-toggle" class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-full w-16 h-16 flex items-center justify-center shadow-2xl hover:shadow-green-500/50 hover:scale-110 transition-all duration-300 relative group">
        <i class="fas fa-comment-dots text-2xl" id="chat-icon"></i>
        <i class="fas fa-times text-2xl hidden" id="close-icon"></i>

        <!-- Notification Badge -->
        <span id="unread-badge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center font-bold hidden animate-bounce">
            1
        </span>

        <!-- Pulse Animation -->
        <span class="absolute inset-0 rounded-full bg-green-500 animate-ping opacity-75"></span>
    </button>

    <!-- Chat Widget -->
    <div id="chatbot-widget" class="hidden absolute bottom-20 right-0 w-96 bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 p-4 text-white">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                    <i class="fas fa-robot text-green-600 text-xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-lg">Asisten PPDB</h3>
                    <div class="flex items-center space-x-1 text-xs text-green-100">
                        <div class="w-2 h-2 bg-green-300 rounded-full animate-pulse"></div>
                        <span>Online</span>
                    </div>
                </div>
                <button id="chatbot-close" class="text-white hover:bg-white/20 rounded-full p-2 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <!-- Chat Messages -->
        <div id="chat-messages" class="h-96 overflow-y-auto p-4 bg-gray-50 space-y-3">
            <!-- Welcome Message -->
            <div class="flex items-start space-x-2 animate-fade-in">
                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-robot text-white text-xs"></i>
                </div>
                <div class="bg-white rounded-2xl rounded-tl-none p-3 shadow-sm max-w-[80%]">
                    <p class="text-sm text-gray-800">
                        👋 Halo! Selamat datang di <strong>PPDB Online</strong>.<br><br>
                        Saya asisten virtual yang siap membantu Anda. Pilih topik di bawah atau kirim pesan langsung!
                    </p>
                </div>
            </div>

            <!-- Quick Reply Buttons -->
            <div id="quick-replies" class="grid grid-cols-2 gap-2 px-10">
                <button class="quick-reply-btn bg-white border-2 border-green-500 text-green-700 rounded-lg p-2 text-xs font-medium hover:bg-green-50 transition" data-question="Bagaimana cara mendaftar?">
                    <i class="fas fa-edit mr-1"></i>Cara Daftar
                </button>
                <button class="quick-reply-btn bg-white border-2 border-blue-500 text-blue-700 rounded-lg p-2 text-xs font-medium hover:bg-blue-50 transition" data-question="Apa saja persyaratan?">
                    <i class="fas fa-file-alt mr-1"></i>Persyaratan
                </button>
                <button class="quick-reply-btn bg-white border-2 border-purple-500 text-purple-700 rounded-lg p-2 text-xs font-medium hover:bg-purple-50 transition" data-question="Jurusan apa saja?">
                    <i class="fas fa-graduation-cap mr-1"></i>Jurusan
                </button>
                <button class="quick-reply-btn bg-white border-2 border-orange-500 text-orange-700 rounded-lg p-2 text-xs font-medium hover:bg-orange-50 transition" data-question="Kapan jadwal pendaftaran?">
                    <i class="fas fa-calendar mr-1"></i>Jadwal
                </button>
                <button class="quick-reply-btn bg-white border-2 border-pink-500 text-pink-700 rounded-lg p-2 text-xs font-medium hover:bg-pink-50 transition" data-question="Cek status pendaftaran">
                    <i class="fas fa-search mr-1"></i>Cek Status
                </button>
                <button class="quick-reply-btn bg-white border-2 border-teal-500 text-teal-700 rounded-lg p-2 text-xs font-medium hover:bg-teal-50 transition" data-question="Kontak admin">
                    <i class="fas fa-phone mr-1"></i>Kontak
                </button>
            </div>
        </div>

        <!-- Input Area -->
        <div class="border-t border-gray-200 p-4 bg-white">
            <form id="chat-form" class="flex items-center space-x-2">
                <input
                    type="text"
                    id="chat-input"
                    placeholder="Ketik pesan Anda..."
                    class="flex-1 border border-gray-300 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    autocomplete="off"
                >
                <button type="submit" class="bg-green-500 text-white rounded-full w-10 h-10 flex items-center justify-center hover:bg-green-600 transition">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
            <div class="mt-2 text-center">
                <a href="https://wa.me/{{ $whatsappNumber ?? '6281234567890' }}?text=Halo,%20saya%20ingin%20bertanya%20tentang%20PPDB"
                   target="_blank"
                   class="inline-flex items-center space-x-2 text-xs text-gray-500 hover:text-green-600 transition">
                    <i class="fab fa-whatsapp text-lg"></i>
                    <span>Chat via WhatsApp</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    #chat-messages::-webkit-scrollbar {
        width: 6px;
    }

    #chat-messages::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    #chat-messages::-webkit-scrollbar-thumb {
        background: #10b981;
        border-radius: 10px;
    }

    #chat-messages::-webkit-scrollbar-thumb:hover {
        background: #059669;
    }

    .typing-indicator {
        display: flex;
        align-items: center;
        space-x: 1px;
    }

    .typing-indicator span {
        width: 8px;
        height: 8px;
        background-color: #9ca3af;
        border-radius: 50%;
        display: inline-block;
        animation: typing 1.4s infinite;
    }

    .typing-indicator span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-indicator span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typing {
        0%, 60%, 100% {
            transform: translateY(0);
        }
        30% {
            transform: translateY(-10px);
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Safety guard: hide widget if chatbot disabled (in case of caching)
    const enabledFlag = '{{ \App\Models\Setting::get('gemini_enabled', 'false') }}' === 'true';
    if (!enabledFlag) {
        const container = document.getElementById('chatbot-container');
        if (container) container.remove();
        return; // stop initialization
    }
    const toggleBtn = document.getElementById('chatbot-toggle');
    const closeBtn = document.getElementById('chatbot-close');
    const widget = document.getElementById('chatbot-widget');
    const chatIcon = document.getElementById('chat-icon');
    const closeIcon = document.getElementById('close-icon');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');
    const quickReplyBtns = document.querySelectorAll('.quick-reply-btn');
    const chatAiUrl = "{{ route('chat.ai') }}";
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // State for status check flow
    let waitingForRegistrationNumber = false;

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
                    <p class="text-sm text-gray-800">${text}</p>
                </div>
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

    // Call AI backend
    async function getAiResponse(message) {
        try {
            const res = await fetch(chatAiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ message })
            });
            if (!res.ok) {
                const data = await res.json().catch(() => ({}));
                return data.reply || 'Maaf, terjadi kesalahan pada asisten AI.';
            }
            const data = await res.json();
            return data.reply;
        } catch (e) {
            return 'Maaf, tidak dapat terhubung ke server. Coba lagi nanti.';
        }
    }

    // Handle form submission
    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const userMessage = chatInput.value.trim();
        if (!userMessage) return;

        // Add user message
        addMessage(userMessage, true);
        chatInput.value = '';

        // Check if waiting for registration number
        if (waitingForRegistrationNumber) {
            waitingForRegistrationNumber = false;
            await checkRegistrationStatus(userMessage);
            return;
        }

        // Show typing indicator
        showTypingIndicator();
        const botResponse = await getAiResponse(userMessage);
        removeTypingIndicator();
        addMessage(botResponse, false);
    });

    // Handle quick reply buttons with local FAQ
    const localFAQ = {
        "Bagaimana cara mendaftar?": `📝 <strong>Cara Mendaftar PPDB Online:</strong><br><br>
            1. Klik tombol <strong>"Daftar Sekarang"</strong> di halaman utama<br>
            2. Isi formulir pendaftaran dengan data lengkap<br>
            3. Pilih maksimal 3 jurusan sesuai minat<br>
            4. Upload dokumen persyaratan (opsional)<br>
            5. Submit formulir pendaftaran<br>
            6. Catat nomor registrasi untuk cek status<br><br>
            ⚠️ <em>Pastikan data yang diisi benar dan valid!</em>`,

        "Apa saja persyaratan?": `📋 <strong>Persyaratan Pendaftaran:</strong><br><br>
            <strong>Wajib:</strong><br>
            • NISN yang valid<br>
            • Ijazah/STTB SMP atau sederajat<br>
            • Akta Kelahiran<br>
            • Kartu Keluarga<br><br>
            <strong>Opsional (dapat diupload setelah diterima):</strong><br>
            • Pas foto 3x4<br>
            • Rapor semester 1-5<br><br>
            💡 <em>Dokumen opsional dapat dilengkapi saat daftar ulang</em>`,

        "Jurusan apa saja?": `🎓 <strong>Jurusan yang Tersedia:</strong><br><br>
            Silakan lihat daftar lengkap jurusan di halaman <strong>"Jurusan"</strong> pada menu utama.<br><br>
            Setiap jurusan memiliki:<br>
            • Deskripsi lengkap<br>
            • Prospek karir<br>
            • Fasilitas pembelajaran<br><br>
            📌 <em>Anda dapat memilih hingga 3 jurusan saat mendaftar</em>`,

        "Kapan jadwal pendaftaran?": `📅 <strong>Jadwal Pendaftaran:</strong><br><br>
            Informasi jadwal lengkap dapat dilihat di halaman utama pada bagian <strong>"Timeline PPDB"</strong>.<br><br>
            Pastikan Anda mendaftar sesuai gelombang yang tersedia:<br>
            • Gelombang 1: Jalur prestasi<br>
            • Gelombang 2: Jalur reguler<br>
            • Gelombang 3: Jalur tambahan<br><br>
            ⏰ <em>Jangan sampai terlewat!</em>`,

        "Cek status pendaftaran": `🔍 <strong>Cara Cek Status:</strong><br><br>
            Saya akan membantu Anda mengecek status pendaftaran.<br><br>
            Silakan masukkan <strong>Nomor Registrasi</strong> Anda di kolom chat di bawah ini.<br><br>
            Contoh format: <code>PPDB2025001</code>`,

        "Kontak admin": `📞 <strong>Hubungi Kami:</strong><br><br>
            <strong>WhatsApp:</strong><br>
            <a href="https://wa.me/{{ $whatsappNumber ?? '6281234567890' }}?text=Halo,%20saya%20ingin%20bertanya%20tentang%20PPDB" target="_blank" class="text-green-600 hover:underline">
                <i class="fab fa-whatsapp"></i> Klik di sini untuk chat
            </a><br><br>
            <strong>Email:</strong> {{ \App\Models\Setting::get('school_email', 'ppdb@sekolah.sch.id') }}<br>
            <strong>Telepon:</strong> {{ \App\Models\Setting::get('school_phone', '021-1234567') }}<br>
            <strong>Alamat:</strong> {{ \App\Models\Setting::get('school_address', 'Jl. Pendidikan No. 123') }}<br><br>
            🕐 <strong>Jam Operasional:</strong> Senin-Jumat, 08:00-16:00 WIB`
    };

    // Function to check registration status
    async function checkRegistrationStatus(registrationNumber) {
        showTypingIndicator();

        try {
            const response = await fetch("{{ route('registration.checkStatusApi') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ registration_number: registrationNumber })
            });

            const data = await response.json();
            removeTypingIndicator();

            // Reset placeholder
            chatInput.placeholder = "Ketik pesan Anda...";

            if (!response.ok || data.error) {
                addMessage(`❌ <strong>Data Tidak Ditemukan</strong><br><br>
                    Nomor registrasi <code>${escapeHtml(registrationNumber)}</code> tidak ditemukan dalam sistem.<br><br>
                    Pastikan Anda memasukkan nomor yang benar.<br><br>
                    💡 Atau <a href="{{ route('registration.checkStatus') }}" class="text-blue-600 hover:underline">klik di sini</a> untuk cek status manual.`, false);
                return;
            }

            // Format status message
            const statusIcons = {
                'draft': '📄',
                'submitted': '⏳',
                'reviewed': '👀',
                'accepted': '✅',
                'rejected': '❌',
                'registered': '📋'
            };

            const statusText = {
                'draft': 'Draft',
                'submitted': 'Menunggu Verifikasi',
                'reviewed': 'Sedang Ditinjau',
                'accepted': 'Diterima',
                'rejected': 'Ditolak',
                'registered': 'Terdaftar'
            };

            let statusMessage = `${statusIcons[data.status] || '📋'} <strong>Status Pendaftaran</strong><br><br>
                <strong>Nomor Registrasi:</strong> ${data.registration_number}<br>
                <strong>Nama:</strong> ${data.name}<br>
                <strong>Status:</strong> <span style="font-weight: bold; color: ${data.status === 'accepted' ? '#10b981' : data.status === 'rejected' ? '#ef4444' : '#f59e0b'};">${statusText[data.status]}</span><br><br>`;

            if (data.status === 'accepted' && data.assigned_major) {
                statusMessage += `🎉 <strong>Selamat!</strong><br>Anda diterima di jurusan: <strong>${data.assigned_major}</strong><br><br>`;
            }

            if (data.status === 'submitted' || data.status === 'registered') {
                statusMessage += `⏳ Dokumen Anda sedang dalam proses verifikasi (2-3 hari kerja).<br><br>`;
            } else if (data.status === 'reviewed') {
                statusMessage += `👀 Pendaftaran Anda sedang ditinjau oleh tim panitia.<br><br>`;
            } else if (data.status === 'accepted') {
                statusMessage += `📧 Silakan cek email untuk informasi daftar ulang.<br><br>`;
            }

            statusMessage += `🔗 <a href="{{ route('registration.checkStatus') }}" class="text-blue-600 hover:underline">Lihat detail lengkap</a>`;

            addMessage(statusMessage, false);

        } catch (error) {
            removeTypingIndicator();
            chatInput.placeholder = "Ketik pesan Anda...";
            addMessage(`❌ <strong>Terjadi Kesalahan</strong><br><br>
                Tidak dapat terhubung ke server. Silakan coba lagi atau gunakan halaman <a href="{{ route('registration.checkStatus') }}" class="text-blue-600 hover:underline">Cek Status manual</a>.`, false);
        }
    }

    quickReplyBtns.forEach(btn => {
        btn.addEventListener('click', async function() {
            const question = this.dataset.question;
            addMessage(question, true);

            // Check if question has local answer
            if (localFAQ[question]) {
                showTypingIndicator();
                // Simulate typing delay for better UX
                await new Promise(resolve => setTimeout(resolve, 800));
                removeTypingIndicator();
                addMessage(localFAQ[question], false);

                // If "Cek status" button clicked, enable status check mode
                if (question === "Cek status pendaftaran") {
                    waitingForRegistrationNumber = true;
                    chatInput.placeholder = "Masukkan nomor registrasi Anda...";
                    chatInput.focus();
                }
            } else {
                // Fallback to AI if not in FAQ
                showTypingIndicator();
                const botResponse = await getAiResponse(question);
                removeTypingIndicator();
                addMessage(botResponse, false);
            }
        });
    });

    // Escape HTML to prevent XSS
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
