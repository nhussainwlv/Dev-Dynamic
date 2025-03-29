document.addEventListener("DOMContentLoaded", function () {
    let toggleButton = document.getElementById("toggleLogin");
    let userTypeField = document.getElementById("userType");

    toggleButton.addEventListener("click", function () {
        if (userTypeField.value === "guest") {
            userTypeField.value = "staff";
            toggleButton.textContent = "Switch to Guest Login";
        } else {
            userTypeField.value = "guest";
            toggleButton.textContent = "Switch to Staff Login";
        }
    });
});