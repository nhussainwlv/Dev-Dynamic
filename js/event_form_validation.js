document.addEventListener("DOMContentLoaded", function () {
    let eventLocationDropdown = document.getElementById("eventLocation");
    let eventRoomDropdown = document.getElementById("eventRoom");

    eventLocationDropdown.addEventListener("change", function () {
        updateRoomOptions();
    });

    function updateRoomOptions() {
        let location = eventLocationDropdown.value;

        // Define valid rooms per location
        let rooms = {
            "Wolverhampton City Campus: Alan Turing Building": ["MI206", "MI207", "MI208", "MI209"],
            "Wolverhampton City Campus: Millennium City Building": ["MC001", "MC002", "MC003", "MC004"],
            "Wolverhampton City Campus: Wulfruna Building": ["MA204", "MA205", "MA206", "MA207"]
        };

        // Clear existing options
        eventRoomDropdown.innerHTML = '<option value="">Unspecified</option>';

        // Populate new room options based on selected location
        if (rooms[location]) {
            rooms[location].forEach(room => {
                let option = document.createElement("option");
                option.value = room;
                option.textContent = room;
                eventRoomDropdown.appendChild(option);
            });
        }
    }
});