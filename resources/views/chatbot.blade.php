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
            {{-- <header class="chat-main-header">
                <div class="chat-partner-info">
                    <img src="{{ asset('images/logo-only.png') }}" alt="Medibot" class="chat-partner-avatar">
                    <span class="chat-partner-name">Medibot AI Assistant</span>
                </div>
                <div class="chat-main-actions">
                    <button><i class="fas fa-ellipsis-v"></i></button>
                </div>
            </header> --}}

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
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            function appendMessage(sender, text) {
                if (chatStartView.style.display !== 'none') {
                    chatStartView.style.display = 'none';
                }

                const messageRow = document.createElement('div');
                messageRow.classList.add('message-row', sender === 'user' ? 'user-row' : 'bot-row');

                const avatarSrc = sender === 'user' ? 'https://via.placeholder.com/32/A03061/FFFFFF?text=U' :
                    '{{ asset('images/logo-only.png') }}';
                const avatar = document.createElement('img');
                avatar.classList.add('message-avatar');
                avatar.src = avatarSrc;
                avatar.alt = sender === 'user' ? 'User' : 'Bot';

                const bubble = document.createElement('div');
                bubble.classList.add('message-bubble', sender === 'user' ? 'user-message' : 'bot-message');
                bubble.innerHTML = text.replace(/\n/g, '<br>');

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
                const messageRow = document.createElement('div');
                messageRow.classList.add('message-row', 'bot-row', 'typing-indicator');

                const avatar = document.createElement('img');
                avatar.classList.add('message-avatar');
                avatar.src = '{{ asset('images/logo-only.png') }}';
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

                    fetch('/api/generate-text', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify({
                                prompt: message // Ubah 'message' menjadi 'prompt' sesuai controller Laravel
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
            if (chatMessages.children.length === 0) {
                chatStartView.style.display = 'flex';
            }
        });
    </script>
@endsection
