
import { submitButton } from "./SubmitButton"; // Assurez-vous que le chemin est correct
class ReCaptcha {
    #isReCaptchaValid = false;

    constructor() {
        window.onloadCallback = this.initializeReCaptcha.bind(this);
    }

    initializeReCaptcha() {
        grecaptcha.render('ReCaptcha', {
            'sitekey': '6Lfny-ApAAAAAJbXdQ12uK7Pk6ALNCdOhNhuM3VE',
            'callback': this.#setReCaptchaStatus.bind(this, true),
            'expired-callback': this.#setReCaptchaStatus.bind(this, false)
        });

        submitButton.init(this); // Ajouter l'instance de ReCaptcha à SubmitButton
    }

    #setReCaptchaStatus(status) {
        this.#isReCaptchaValid = status;
        const event = new CustomEvent('validationChange');
        document.getElementById('ReCaptcha').dispatchEvent(event);
    }

    getValid() {
        return this.#isReCaptchaValid;
    }

    getElement() {
        return document.getElementById('ReCaptcha');
    }
}


if (document.getElementById('ReCaptcha')) {
    new ReCaptcha();
}