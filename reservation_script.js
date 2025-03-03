document.getElementById('book-button').addEventListener('click', function() {
    const date = document.getElementById('date').value;
    const time = document.getElementById('time').value;

    if (date === "" || time === "") {
        alert("Please select both date and time.");
    } else {
        document.getElementById('confirmation-box').classList.remove('hidden');
    }
});

document.getElementById('close-button').addEventListener('click', function() {
    document.getElementById('confirmation-box').classList.add('hidden');
});
