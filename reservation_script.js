document.getElementById('reservation-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default page reload

    const date = document.getElementById('date').value;
    const time = document.getElementById('time').value;

    if (!date || !time) {
        alert("❌ Please select both date and time.");
        return;
    }

    // Send data to reservation.php
    fetch('reservation.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `date=${encodeURIComponent(date)}&time=${encodeURIComponent(time)}`
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('confirmation-message').innerText = data;
        document.getElementById('confirmation-message').classList.remove("hidden");
    })
    .catch(error => {
        alert("❌ Error submitting reservation.");
        console.error(error);
    });
});
