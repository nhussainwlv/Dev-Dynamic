document.getElementById('book-button').addEventListener('click', function() {
    const selectedEvent = document.getElementById('event-select').value;

    if (selectedEvent === "") {
        alert("Please select an event.");
    } else {
        const confirmationText = document.getElementById('confirmation-text');
        confirmationText.textContent = `Your reservation for "${selectedEvent}" has been booked successfully!`;

        const confirmationBox = document.getElementById('confirmation-box');
        confirmationBox.classList.remove('hidden');
    }
});

document.getElementById('close-button').addEventListener('click', function() {
    document.getElementById('confirmation-box').classList.add('hidden');
});
