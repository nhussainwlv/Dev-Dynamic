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
                <li data-category="category1">📂 | Course Help</li>
                <li data-category="category2">📂 | Booking a Reservation</li>
                <li data-category="category3">📂 | Accomodation Help</li>
            </ul>
            <div id="faq-questions" class="hidden"></div>
        </div>
    </div>
</section>