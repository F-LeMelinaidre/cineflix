// Validation Email en utilisant la norme RFC2822
const inputs = [];

const rules = {
    alpha: {
        callback: (value) => {
            const regex = new RegExp(/^[a-zA-Zàâçéèêëïîôùûüÿ\-\s]+$/);
            return regex.test(value);
        },
        message: `Caractères alphabétiques uniquement !`,
    },
    alphaNumeric: {
        callback: (value) => {
            const regex = new RegExp(/^[0-9a-zA-Zàâçéèêëïîôùûüÿ\-\s]+$/);
            return regex.test(value);
        },
        message: `Caractères alpha-numériques uniquement !`
    },
    alphaNumericExtended: {
        callback: (value) => {
            const regex = new RegExp(/^[0-9a-zA-Zàâçéèêëïîôùûüÿ\-!?:,.\s()&']+$/);
            return regex.test(value);
        },
        message: `Uniquement les caractères alpha-numériques et -!?:,.()& autorisés !`
    },
    email: {
        callback: (value) => {
            const regex = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
            return regex.test(value);
        },
        message: `Votre email ne respete pas la norme RFC2822 !`,
    },
    minLength: {
        callback: (value, min) => {
            return (min <= value.length);
        },
        message: (min) => `Doit comporter au minimum ${min} caratères !`,
    },
    numeric: {
        callback: (value) => {
            const regex = new RegExp(/^[0-9]+$/);
            return regex.test(value);
        },
        message: `Caractères numériques uniquement !`
    },
    password: {
        callback: (value) => {
            const regex = new RegExp(/^(?=.*[a-zA-Z0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[!?:_\-*#&%+]).{8,}$/);
            return regex.test(value);
        },
        message: `8 caratères minimum, comprenant au minimum une majascule, une minusclule, un chiffre, et un caratère !?:_-*#&%+ !`,
    },
    require: {
        callback: (value) => {
            return (0 < value.length);
        },
        message: `Champs requis !`,
    },
}

document.addEventListener('DOMContentLoaded', function () {

    const items = document.querySelectorAll('input, textarea');
    const button = document.querySelector('button');

    let hasRequired = false;

    items.forEach(function (item, i) {

        let inputRules = [];

        if(item.hasAttribute('aria-required') &&
            'true' === item.getAttribute('aria-required')) {
            inputRules.push('require');

            if(!hasRequired) hasRequired = true;
        }


        if(item.hasAttribute('minlength')) inputRules.push('minLength');
        if(item.hasAttribute('password')) inputRules.push('email');
        if(item.hasAttribute('password')) inputRules.push('password');


        if(item.hasAttribute('data-validation')) {

            let validationRules = item.getAttribute('data-validation').split(' ');

            inputRules = inputRules.concat(validationRules);

        }

        if(0 !== inputRules.length) addValidationListener(item, inputRules);
    });


    if(hasRequired) {
        button.disabled = true;
    }

});

/**
 * Ajout d'un écouteur d'événements pour la validation
 * @param {HTMLElement} item - Le champ du formulaire
 * @param {Array} rules
 */
function addValidationListener(item, rules) {

    let timeout;


    item.addEventListener('input', function () {

        const inputId = item.id;
        let value = item.value;


        timeout = setTimeout(function() {



        }, 500);
    });
}

/**
 *
 * @param {HTMLElement} item - Le champ du formulaire
 * @param {string} message - Message d'erreur
 */
function addAlertMessage(item, message) {
    const inputId = item.id;
    item.setAttribute('aria-describedby', 'Alert' + inputId);
    item.setAttribute('aria-invalid', 'true');

    const alertDiv = document.createElement('div');
    alertDiv.id = 'Alert' + inputId;
    alertDiv.className = 'invalid-message';
    alertDiv.setAttribute('role', 'alert');
    alertDiv.textContent = message;
    item.insertAdjacentElement('afterend', alertDiv);

}

/**
 *
 * @param {HTMLElement} item
 */
function removeAlertMessge(item) {
    const inputId = item.id;
    const alertMessage = document.getElementById('Alert' + inputId);
    if (alertMessage) alertMessage.remove();

}