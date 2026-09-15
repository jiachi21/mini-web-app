const form = document.getElementById("messageForm");
const nameInput = document.getElementById("name");
const messageInput = document.getElementById("message");
const submitButton = document.getElementById("submitButton");

form.addEventListener("submit", function (event) {
    const name = nameInput.value.trim();
    const message = messageInput.value.trim();

    if (name === "" || message === "") {
        event.preventDefault();

        alert("Please enter both your name and a message.");

        return;
    }

    submitButton.disabled = true;
    submitButton.textContent = "Saving...";
});