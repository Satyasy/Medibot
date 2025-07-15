@extends('layouts.app') {{-- Halaman chatbot tetap menggunakan layout utama --}}

@section('title', 'Chatbot Medibot')

@section('styles')
    {{-- Kita tetap menggunakan landing.css, tapi CSS-nya akan disesuaikan --}}
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
@endsection

@section('content')
    {{-- Kontainer utama untuk halaman chatbot --}}
    <div class="chatbot-page-container">
        <!-- Sidebar Kiri -->
        <div class="chat-sidebar">
            <div class="sidebar-header">
                <a href="{{ url('/') }}"><img src="{{ asset('images/logo-medibot.png') }}" alt="Medibot Logo"
                        class="logo"></a>
            </div>
            <div class="sidebar-menu">
                <a href="#">+ Obrolan Baru</a>
                <a href="#"> Cari Obrolan</a>
            </div>
            <div class="history-title">OBROLAN</div>
            <div class="sidebar-menu history-list">
                <a href="#">Gejala Batuk, pilek</a>
                <a href="#">Cara diet</a>
                <a href="#">Atasi sakit gigi</a>
            </div>
        </div>

        <!-- Area Chat Utama -->
        <div class="chat-main">
            <div class="chat-messages" id="chat-messages">
                <!-- Tampilan Awal dengan logo Medibot -->
                <div class="chat-start-view" id="chat-start-view">
                    <img src="{{ asset('images/logo-medibot.png') }}" alt="Medibot Logo Large" class="large-logo">
                    <h2 style="color: #eaeaea; margin-top: 20px;">Selamat Datang di Medibot</h2>
                    <p style="color: #aaa;">Tanyakan keluhan apa saja pada saya.</p>
                </div>
            </div>
            <div class="chat-input-area">
                <form id="chat-form">
                    <input type="text" id="chat-input" placeholder="Tanya keluhan apa saja pada Medibot..."
                        autocomplete="off">
                    <button type="submit" id="send-btn">➤</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Script untuk Fungsionalitas Chatbot ---
            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-input');
            const chatMessages = document.getElementById('chat-messages');
            let chatStartView = document.getElementById('chat-start-view');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Fungsi saat form di-submit
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const userMessage = chatInput.value.trim();

                if (userMessage) {
                    if (chatStartView) {
                        chatStartView.remove();
                        chatStartView = null;
                    }

                    appendMessage(userMessage, 'user');
                    chatInput.value = '';
                    showTypingIndicator();

                    fetch("{{ url('/api/generate-text') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                // 'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                prompt: userMessage
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            removeTypingIndicator();
                            if (data && data.reply) {
                                appendMessage(data.reply, 'bot', data.source);
                            } else {
                                appendMessage('Maaf, terjadi kesalahan dalam memproses jawaban.',
                                    'bot');
                            }
                        })
                        .catch(error => {
                            removeTypingIndicator();
                            appendMessage('Maaf, terjadi kesalahan koneksi. Coba lagi nanti.', 'bot');
                            console.error('Error:', error);
                        });
                }
            });

            function appendMessage(text, sender, source = null) {
                const messageBubble = document.createElement('div');
                messageBubble.classList.add('message-bubble', `${sender}-message`);
                const content = document.createElement('p');
                content.innerHTML = text.replace(/\n/g, '<br>');
                messageBubble.appendChild(content);

                if (source && sender === 'bot') {
                    const sourceDiv = document.createElement('div');
                    sourceDiv.className = 'source';
                    sourceDiv.textContent = `Sumber: ${source}`;
                    messageBubble.appendChild(sourceDiv);
                }
                chatMessages.appendChild(messageBubble);
                scrollToBottom();
            }

            function showTypingIndicator() {
                const indicator = document.createElement('div');
                indicator.classList.add('message-bubble', 'bot-message', 'typing-indicator');
                indicator.innerHTML = `<span></span><span></span><span></span>`;
                chatMessages.appendChild(indicator);
                scrollToBottom();
            }

            function removeTypingIndicator() {
                const indicator = document.querySelector('.typing-indicator');
                if (indicator) indicator.remove();
            }

            function scrollToBottom() {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    </script>
@endsection
