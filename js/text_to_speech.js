let isReading = false;

function readText(element) {
    if (isReading) {
        window.speechSynthesis.cancel();
        isReading = false;
    } else {
        // It was so difficult to not get the text-to-speech to read the speaker emoji, so this solution is extremely convoluted.
        const text = Array.from(element.childNodes)
            .filter(node => node.nodeType === Node.TEXT_NODE || node.tagName === "A") // Include text and <a> tags only
            .map(node => node.textContent.trim())
            .join(" ");

        const speech = new SpeechSynthesisUtterance(text);
        speech.lang = 'en-GB';
        speech.pitch = 1; // Adjust pitch (1 is normal)
        speech.rate = 1; // Adjust rate of speech (1 is normal)

        speech.onstart = () => {
            isReading = true;
        };

        speech.onend = () => {
            isReading = false;
        };

        window.speechSynthesis.speak(speech);
    }
}