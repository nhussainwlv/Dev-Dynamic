document.addEventListener("DOMContentLoaded", function () {
    const chatbotButton = document.getElementById("chatbot-button");
    const chatbotContainer = document.getElementById("chatbot-container");
    const closeChatbot = document.getElementById("close-chatbot");
    const faqCategories = document.getElementById("faq-categories");
    const faqQuestions = document.getElementById("faq-questions");

    // Updated FAQ Data
    const faqData = {
        "category1": [
            { question: "What courses are available?", answer: "You can view all courses available by navigating to the Courses section, found in the Navigation bar." },
            { question: "Where can I find more information about my Course?", answer: "Each course links to it's respective Guide on the University Website." },
            { question: "What types of courses are offered?", answer: "Students are able to study Online, Part-Time and Full-Time courses, with an optional Sandwich year." }
        ],
        "category2": [
            { question: "Where can I book an Open Day Reservation?", answer: "You can book a reservation by navigating to the Book Reservation section, found in the Navigation bar." },
            { question: "What type of Events can I book a reservation for?", answer: "We offer Course specific Open-Day events, Guest Lectures and University-ground Tours." },
            { question: "Can I bring my family with me?", answer: "We allow reservations of groups up to 4 people to allow space for other groups of guests." }
        ],
        "category3": [
            { question: "Where can I find Accomodation information?", answer: "You can find Accomodation information by navigating to the Accomodation section, found in the Navigation bar." },
            { question: "How long can I book an Accomodation for?", answer: "We offer standard 52 and 42 week licenses, as well as Semester specific licenses." }
        ]
    };

    // Open chatbot
    chatbotButton.addEventListener("click", () => {
        chatbotContainer.classList.toggle("hidden");
    });

    // Close chatbot
    closeChatbot.addEventListener("click", () => {
        chatbotContainer.classList.add("hidden");
    });

    // Handle category click
    faqCategories.addEventListener("click", (event) => {
        if (event.target.tagName === "LI") {
            const category = event.target.getAttribute("data-category");
            displayFAQs(category);
        }
    });

    // Display questions when a category is clicked
    function displayFAQs(category) {
        faqQuestions.innerHTML = "";
        faqQuestions.classList.remove("hidden");

        faqData[category].forEach(item => {
            const questionDiv = document.createElement("div");
            questionDiv.classList.add("faq-item");
            questionDiv.textContent = item.question;

            const answerDiv = document.createElement("div");
            answerDiv.classList.add("faq-answer", "hidden");
            answerDiv.textContent = item.answer;

            questionDiv.addEventListener("click", () => {
                answerDiv.classList.toggle("hidden");
            });

            faqQuestions.appendChild(questionDiv);
            faqQuestions.appendChild(answerDiv);
        });
    }
});