class SubmitButton {

    /** @type {HTMLElement} */
    #button
    /** @type {array} */
    #validationInstances
    #timer;

    constructor() {
        this.#button = document.querySelector('.js-submit-button');
        this.#validationInstances = [];
        this.#button.disabled = true;

    }

    /**
     *
     * @param instance
     */
    init(instance) {
        const input = instance.getElement();
        this.#validationInstances.push(instance);

        input.addEventListener('validationChange', () => {
            this.#updateValidity();
        });

        const containerButton = this.#button.parentElement;
        containerButton.addEventListener('mouseover', () => {
            this.#checkAllFieldsValidity(); // Vérifier la validité de tous les champs lors du survol du parent du bouton
        });
    }

    /**
     *
     */
    #updateValidity() {
        const allValid = this.#validationInstances.every(instance => instance.getValid());
        this.#button.disabled = !allValid;
    }

    #checkAllFieldsValidity() {
        this.#validationInstances.forEach(instance => instance.checkValidity());
        this.#updateValidity();
    }

}

export const submitButton = new SubmitButton();