function togglePasswordVisibility(buttonId, passwordFieldId, iconId) {
    document.getElementById(buttonId).addEventListener('click', function () {
        var passwordField = document.getElementById(passwordFieldId);
        var passwordIcon = document.getElementById(iconId);
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            passwordIcon.classList.remove('bi-eye');
            passwordIcon.classList.add('bi-eye-slash');
        } else {
            passwordField.type = 'password';
            passwordIcon.classList.remove('bi-eye-slash');
            passwordIcon.classList.add('bi-eye');
        }
    });
}

// Call the function with specific IDs
togglePasswordVisibility('toggle-password', 'reg-password', 'toggle-password-icon');
