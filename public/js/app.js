
import apiConfig from './api/apiConfig';

if (document.querySelector('.js-form')) {
    (async () => {

        const validateInstances = await initValidateInput();

        const submitButton = document.querySelector('.js-submit-button');

        const reCaptcha = document.getElementById('ReCaptcha');
        if (reCaptcha) {
            const { ReCaptcha } = await import("./class/reCaptcha");

            const reCaptchaInstance = new ReCaptcha(reCaptcha);
            validateInstances.push(reCaptchaInstance);
        }

        if (submitButton) {
            const {SubmitForValidateClass} = await import("./class/SubmitForValidateClass");

            new SubmitForValidateClass(submitButton, validateInstances);
        }

    })();
}

async function initValidateInput() {
    const {ValidateClass} = await import("./class/ValidateClass");

    const validateInstances = [];

    document.querySelectorAll('.js-validation').forEach(elem => {

        validateInstances.push(new ValidateClass(elem));

    });

    return validateInstances;
}

const inputCinema = document.getElementById('InputCinema');
if (inputCinema) {
    (async () => {
        const {InputAutocomplete} = await import('./component/InputAutcomplete');

        const autocomplete = new InputAutocomplete({
            input: inputCinema,
            label: 'nom',
            value: 'id',
            request: apiConfig.cinema.search
        });

        autocomplete.setupAutocomplete();
    })();
}


const inputVille = document.getElementById('InputVille');
if (inputVille) {
    (async () => {
        const {InputAutocomplete} = await import('./component/InputAutcomplete');

        const autocomplete = new InputAutocomplete({
            input: inputVille,
            label: 'nom',
            value: 'id',
            request: apiConfig.ville.search
        });

        autocomplete.setupAutocomplete();
    })();
}


