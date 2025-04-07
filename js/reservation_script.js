// Ensure HTML elements are fully loaded before attaching event listeners
document.addEventListener('DOMContentLoaded', function () {

    // Event listener for booking button
    document.getElementById('book-button').addEventListener('click', function() {

        // Get selected event and amount of people from the dropdowns
        const selectedEvent = document.getElementById('event-select').value;
        const amountOfPeople = document.getElementById('amount-select').value;

        // Validate inputs and display appropriate alerts if fields are missing
        if (!selectedEvent && !amountOfPeople) {
            alert("Please select an event and the number of people attending.");
        } else if (!selectedEvent) {
            alert("Please select an event.");
        } else if (!amountOfPeople) {
            alert("Please select the number of people attending.");
        } else {
            // Both selections are valid; update the confirmation text
            const confirmationText = document.getElementById('confirmation-text');
            confirmationText.textContent = `Your reservation for "${selectedEvent}" with ${amountOfPeople} ${amountOfPeople === "1" ? 'person' : 'people'} has been booked successfully!`;

            // Display the confirmation box
            document.getElementById('confirmation-box').classList.remove('hidden');
        }
    });

    // Event listener to close the confirmation message box
    document.getElementById('close-button').addEventListener('click', function() {
        document.getElementById('confirmation-box').classList.add('hidden');
    });

});
