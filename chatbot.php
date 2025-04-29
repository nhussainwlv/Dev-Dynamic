<script src="js/chatbot.js" defer></script> <!-- JS for chatbot functionality -->

<section id="chatbot">
    <!-- Chatbot Button -->
    <div id="chatbot-button">💬 Questions?</div>

    <!-- Chatbot Window -->
    <div id="chatbot-container" class="hidden">
        <div id="chatbot-header">
            <span>Hello! You are speaking with our interactive FAQ Chatbot! 🙂 </span>
            <button id="close-chatbot">✖</button>
        </div>
        <div id="chatbot-content">
            <ul id="faq-categories">
                <li data-category="category1">📂 | Category 1</li>
                <li data-category="category2">📂 | Category 2</li>
                <li data-category="category3">📂 | Category 3</li>
            </ul>
            <div id="faq-questions" class="hidden"></div>
        </div>
    </div>
</section>