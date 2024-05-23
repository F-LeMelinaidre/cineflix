export class ReCaptcha {

    /** @type {boolean} */
    #isReCaptchaValid = false;
    /** @type {HTMLElement} */
    #reCaptcha

    constructor(reCaptcha) {
        this.#reCaptcha = reCaptcha;

        window.onloadCallback = this.initializeReCaptcha.bind(this);
    }

    initializeReCaptcha() {
        grecaptcha.render('ReCaptcha', {
            'sitekey': '6Lfny-ApAAAAAJbXdQ12uK7Pk6ALNCdOhNhuM3VE',
            'callback': this.#setReCaptchaStatus.bind(this, true),
            'expired-callback': this.#setReCaptchaStatus.bind(this, false)
        });

    }

    #setReCaptchaStatus(status) {
        this.#isReCaptchaValid = status;
        const event = new CustomEvent('validationChange');
        this.#reCaptcha.dispatchEvent(event);
    }

    getValid() {
        return this.#isReCaptchaValid;
    }

    getElement() {
        return this.#reCaptcha
    }

    checkValidity() {

        return this.getValid();
    }
}