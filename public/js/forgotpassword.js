document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("forgotForm");
    const emailInput = document.getElementById("email");
    const errorEmail = document.querySelector("[data-error-for='email']");

    form.addEventListener("submit", (e) => {
        let valid = true;
        errorEmail.style.display = "none";

        if (!emailInput.value.trim()) {
            errorEmail.textContent = "Email wajib diisi.";
            errorEmail.style.display = "block";
            valid = false;
        } else if (!/^\S+@\S+\.\S+$/.test(emailInput.value)) {
            errorEmail.textContent = "Format email tidak valid.";
            errorEmail.style.display = "block";
            valid = false;
        }

        if (!valid) {
            e.preventDefault();
        }
    });
});
