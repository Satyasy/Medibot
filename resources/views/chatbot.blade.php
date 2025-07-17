@extends('layouts.app')

@section('title', 'Medibot Chatbot')

{{-- Memberikan class 'chatbot-page' ke elemen body untuk CSS spesifik --}}
@section('body_class', 'chatbot-page')

@section('styles')
    {{-- Memuat CSS spesifik untuk chatbot setelah app.css --}}
    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">
@endsection

@section('content')
    {{-- Kontainer utama untuk tampilan chatbot --}}
    <div id="chatbot-container-new">
        {{-- Area Chat Utama --}}
        <main class="chat-main-area">
            {{-- Header internal chatbot --}}
            <header class="chat-main-header">
                <div class="chat-partner-info">
                    <img src="{{ asset('images/logo-only.png') }}" alt="Medibot" class="chat-partner-avatar">
                    <span class="chat-partner-name">Medibot AI Assistant</span>
                </div>
                <div class="chat-main-actions">
                    <button><i class="fas fa-ellipsis-v"></i></button>
                </div>
            </header>

            {{-- Area Pesan Chat --}}
            <div class="chat-messages-display" id="chat-messages">
                <div class="chat-start-view" id="chat-start-view">
                    <h3 class="welcome-title-chat">Selamat Datang di Medibot</h3>
                    <p class="welcome-text-chat">
                        Tanyakan keluhan apa saja pada saya.
                    </p>
                </div>
                {{-- Pesan akan ditambahkan di sini oleh JavaScript --}}
            </div>

            {{-- Area Input Chat --}}
            <div class="chat-input-area">
                <form id="chat-form">
                    @csrf
                    <button type="button" class="input-attach-btn"><i class="fas fa-smile"></i></button>
                    <input type="text" id="chat-input" placeholder="Tanya keluhan apa saja pada Medibot..."
                        autocomplete="off">
                    <button type="submit" id="send-btn"><i class="fas fa-paper-plane"></i></button>
                </form>
            </div>
        </main>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-input');
            const chatMessages = document.getElementById('chat-messages');
            const chatStartView = document.getElementById('chat-start-view');
            const chatbotApiUrl = '/api/generate-text'; // Pastikan URL ini benar

            function scrollToBottom() {
                // Gunakan setTimeout untuk memastikan DOM diperbarui sebelum menggulir
                setTimeout(() => {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }, 50); // Penundaan kecil agar DOM sempat render
            }

            /**
             * Fungsi untuk memformat teks balasan bot:
             * - Mengubah **teks** menjadi <strong>teks</strong>
             * - Mengubah * item menjadi <ul><li>item</li></ul>
             * - Mengubah setiap baris menjadi <p> untuk paragraf.
             */
            function formatBotMessage(text) {
                // 1. Proses bold: **text** -> <strong>text</strong>
                // Ini harus dilakukan pertama agar bold di dalam list item juga terdeteksi
                let formattedText = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

                const lines = formattedText.split('\n');
                let htmlOutput = '';
                let inList = false;

                lines.forEach(line => {
                    const trimmedLine = line.trim();
                    if (trimmedLine.startsWith('* ')) {
                        if (!inList) {
                            htmlOutput += '<ul>'; // Mulai daftar baru
                            inList = true;
                        }
                        // Hapus awalan "* " dan tambahkan sebagai item daftar
                        htmlOutput += `<li>${trimmedLine.substring(2)}</li>`;
                    } else {
                        if (inList) {
                            htmlOutput += '</ul>'; // Tutup daftar jika sebelumnya dalam daftar
                            inList = false;
                        }
                        // Perlakukan sebagai paragraf, tapi hanya jika baris tidak kosong
                        if (trimmedLine !== '') {
                            htmlOutput += `<p>${trimmedLine}</p>`;
                        }
                    }
                });

                // Tutup daftar yang mungkin masih terbuka di akhir teks
                if (inList) {
                    htmlOutput += '</ul>';
                }

                // Fallback: Jika setelah semua pemrosesan, output HTML kosong
                // namun teks aslinya tidak kosong (misal: hanya spasi atau karakter tak terformat),
                // maka kembalikan teks asli dengan <br> untuk mempertahankan baris baru.
                // Ini juga menangani kasus di mana tidak ada markdown yang terdeteksi
                // dan kita ingin baris-baris dipisahkan oleh <br> secara default, bukan <p>.
                if (htmlOutput.trim() === '' && text.trim() !== '') {
                    return text.replace(/\n/g, '<br>');
                }

                return htmlOutput;
            }

            function appendMessage(sender, text) {
                if (chatStartView.style.display !== 'none') {
                    chatStartView.style.display = 'none';
                }

                const messageRow = document.createElement('div');
                messageRow.classList.add('message-row', sender === 'user' ? 'user-row' : 'bot-row');

                // Untuk avatar user, sekarang menggunakan profile-picture.png
                // Untuk bot, menggunakan logo-only.png
                const avatarSrc = sender === 'user' ? '{{ asset('images/profile-picture.png') }}' : // Gambar profil untuk User
                    '{{ asset('images/logo-only.png') }}'; // Logo Medibot untuk Bot
                const avatar = document.createElement('img');
                avatar.classList.add('message-avatar');
                avatar.src = avatarSrc;
                avatar.alt = sender === 'user' ? 'User' : 'Bot';

                const bubble = document.createElement('div');
                bubble.classList.add('message-bubble', sender === 'user' ? 'user-message' : 'bot-message');

                if (sender === 'bot') {
                    // Terapkan fungsi formatBotMessage hanya untuk pesan dari bot
                    bubble.innerHTML = formatBotMessage(text);
                } else {
                    // Untuk pesan user, cukup ganti newline dengan <br>
                    bubble.innerHTML = text.replace(/\n/g, '<br>');
                }

                if (sender === 'user') {
                    messageRow.appendChild(bubble);
                    messageRow.appendChild(avatar);
                } else {
                    messageRow.appendChild(avatar);
                    messageRow.appendChild(bubble);
                }

                chatMessages.appendChild(messageRow);
                scrollToBottom();
            }

            function appendTypingIndicator() {
                if (chatStartView.style.display !== 'none') {
                    chatStartView.style.display = 'none';
                }

                const messageRow = document.createElement('div');
                messageRow.classList.add('message-row', 'bot-row', 'typing-indicator');

                const avatar = document.createElement('img');
                avatar.classList.add('message-avatar');
                avatar.src = '{{ asset('images/logo-only.png') }}'; // Avatar bot untuk typing indicator
                avatar.alt = 'Bot';

                const bubble = document.createElement('div');
                bubble.classList.add('message-bubble', 'bot-message');
                bubble.innerHTML = `
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                `;

                messageRow.appendChild(avatar);
                messageRow.appendChild(bubble);
                chatMessages.appendChild(messageRow);
                scrollToBottom();
                return messageRow;
            }

            function removeTypingIndicator(indicatorElement) {
                if (indicatorElement) {
                    indicatorElement.remove();
                }
            }

            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const message = chatInput.value.trim();
                if (message) {
                    appendMessage('user', message);
                    chatInput.value = '';

                    const typingIndicator = appendTypingIndicator();

                    fetch(chatbotApiUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                prompt: message
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            removeTypingIndicator(typingIndicator);
                            appendMessage('bot', data.reply ||
                                'Maaf, saya tidak bisa memberikan jawaban saat ini.');

                            // Tambahkan sumber jika ada (opsional)
                            if (data.source) {
                                appendMessage('bot', `🔍 Sumber: ${data.source}`);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            removeTypingIndicator(typingIndicator);
                            appendMessage('bot', 'Gagal terhubung ke server. Silakan coba lagi.');
                        });
                }
            });

            // Initial state for chat messages (show welcome state)
            // Ini akan memastikan welcome view muncul jika tidak ada pesan saat halaman dimuat
            if (chatMessages.children.length === 0 || (chatMessages.children.length === 1 && chatMessages.firstElementChild.id === 'chat-start-view')) {
                chatStartView.style.display = 'flex';
            } else {
                 chatStartView.style.display = 'none'; // Sembunyikan jika sudah ada pesan (misal dari riwayat)
                 scrollToBottom(); // Gulir ke bawah jika ada pesan lama
            }
        });
    </script>
@endsection
