document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-link');
    const contentTabs = document.querySelectorAll('.content-tab');

    navLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();

            const clickedId = this.id;
            const targetName = clickedId.substring(4);
            const targetContentId = 'content-' + targetName;

            navLinks.forEach(nav => nav.classList.remove('active'));
            this.classList.add('active');

            contentTabs.forEach(tab => tab.classList.remove('active'));
            
            const targetTab = document.getElementById(targetContentId);
            
            if (targetTab) {
                targetTab.classList.add('active');
            }
        });
    });

    const togglePasswordIcons = document.querySelectorAll('.password-toggle-icon');

    togglePasswordIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const passwordInput = this.previousElementSibling;
            const isPassword = passwordInput.type === 'password';

            if (isPassword) {
                passwordInput.type = 'text';
                this.src = '/meuManoBurger/templates/assets/img/olho.png';
            } else {
                passwordInput.type = 'password';
                this.src = '/meuManoBurger/templates/assets/img/olhofechado.png';
            }
        });
    });
});
