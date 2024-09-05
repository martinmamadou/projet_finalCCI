
    document.addEventListener('DOMContentLoaded', function () {
        const togglePasswordButton = document.getElementById('toggle-password');
        const passwordField = document.getElementById('password');

        togglePasswordButton.addEventListener('click', function () {
            const type = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = type;
            togglePasswordButton.textContent = type === 'password' ? 'Show' : 'Hide';
        });
    });
