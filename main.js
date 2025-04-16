document.addEventListener("DOMContentLoaded", function () {
    const email1 = document.querySelector("input[name='email1']");
    const email2 = document.querySelector("input[name='email2']");
    const password1 = document.querySelector("input[name='password1']");
    const password2 = document.querySelector("input[name='password2']");
    const registerButton = document.querySelector("form button[type='submit']");

    // Create warning messages
    const emailWarning = document.createElement("p");
    emailWarning.style.color = "red";
    emailWarning.style.fontSize = "0.9em";
    emailWarning.style.margin = "5px 0";
    emailWarning.style.display = "none";
    emailWarning.textContent = "Emails do not match!";

    const passwordWarning = document.createElement("p");
    passwordWarning.style.color = "red";
    passwordWarning.style.fontSize = "0.9em";
    passwordWarning.style.margin = "5px 0";
    passwordWarning.style.display = "none";
    passwordWarning.textContent = "Passwords do not match!";

    // Insert warnings after respective input fields
    email2.parentNode.appendChild(emailWarning);
    password2.parentNode.appendChild(passwordWarning);

    function validateEmails() {
        if (email1.value !== email2.value && email2.value !== "") {
            emailWarning.style.display = "block";
        } else {
            emailWarning.style.display = "none";
        }
        updateButtonState();
    }

    function validatePasswords() {
        if (password1.value !== password2.value && password2.value !== "") {
            passwordWarning.style.display = "block";
        } else {
            passwordWarning.style.display = "none";
        }
        updateButtonState();
    }

    function updateButtonState() {
        let emailsMatch = email1.value === email2.value && email1.value !== "";
        let passwordsMatch = password1.value === password2.value && password1.value !== "";
        registerButton.disabled = !(emailsMatch && passwordsMatch);
    }

    email1.addEventListener("input", validateEmails);
    email2.addEventListener("input", validateEmails);
    password1.addEventListener("input", validatePasswords);
    password2.addEventListener("input", validatePasswords);

    // Disable button initially
    registerButton.disabled = true;
});
function togglePassword(fieldId) {
    const passwordField = document.getElementById(fieldId);
    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordField.setAttribute('type', type);
}