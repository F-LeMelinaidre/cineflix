export class PasswordManager {
    #inputPasswordId = 'Password';
    #visibilityLinkId = 'Visibility';
    #newPasswordLinkId = 'NewPassword';

    constructor() {
        const visibilityLink = document.getElementById(this.#visibilityLinkId);
        const newPasswordLink = document.getElementById(this.#newPasswordLinkId);

        if (visibilityLink) {
            visibilityLink.addEventListener('click', (event) => {
                event.preventDefault();
                this.toggleVisibility();
            });
        }

        if (newPasswordLink) {
            newPasswordLink.addEventListener('click', (event) => {
                event.preventDefault();
                this.getNewPassword();
            });
        }
    }

    toggleVisibility() {
        const button = document.getElementById(this.#visibilityLinkId);
        const input = document.getElementById(this.#inputPasswordId);

        button.classList.toggle('visibility-off-icon');
        button.classList.toggle('visibility-icon');

        if (input.type === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    }

    getNewPassword() {
        const inputPassword = document.getElementById(this.#inputPasswordId);
        const randomPassword = this.generatePassword();

        inputPassword.value = randomPassword;
    }

    generatePassword() {
        const minuscule = "abcdefghijklmnopqrstuvwxyz";
        const majuscule = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        const nombre = "0123456789";
        const special = "!?:_-*#&%+";

        let password = "";

        password += minuscule.charAt(Math.floor(Math.random() * minuscule.length));
        password += majuscule.charAt(Math.floor(Math.random() * majuscule.length));
        password += nombre.charAt(Math.floor(Math.random() * nombre.length));
        password += special.charAt(Math.floor(Math.random() * special.length));

        const longueurRestante = 12 - 4;
        const caracteres = minuscule + majuscule + nombre + special;

        for (let i = 0; i < longueurRestante; i++) {
            password += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
        }

        password = password.split('').sort(() => Math.random() - 0.5).join('');

        return password;
    }
}

// Usage
const passwordManager = new PasswordManager();