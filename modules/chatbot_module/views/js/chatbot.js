document.addEventListener('DOMContentLoaded', function() {
    // Initialize your chatbot
    const chatbot = new Chatbot({
        apiKey: window.chatbotAPIKey, // API key passed from PHP
        container: document.getElementById('chatbot-container'),
    });

    chatbot.init();
});
