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
        message: `Champs requis !`,
    },
}

document.addEventListener('DOMContentLoaded', function () {

    const items = document.querySelectorAll('input, textarea');

    items.forEach(function (item) {

        let inputRules = [];

        if(item.hasAttribute('aria-required') &&
            'true' === item.getAttribute('aria-required')) {
            inputRules.push('require');

            item.setAttribute('aria-invalid', 'true');

        }

        if(item.hasAttribute('range-end')) {
            let end = item.getAttribute('range-end');
            let rule = `dateRange-end-${end}`;

            inputRules.push(rule);
        }
        if(item.hasAttribute('range-start')) {
            let start = item.getAttribute('range-start');
            let rule = `dateRange-start-${start}`;

            inputRules.push(rule);
        }

        if(item.type =='min') inputRules.push('minLength');
        if(item.type == 'email') inputRules.push('email');
        if(item.type == 'password') inputRules.push('password');


        if(item.hasAttribute('data-validation')) {

            let validationRules = item.getAttribute('data-validation').split(' ');

            inputRules = inputRules.concat(validationRules);

        }

        if(0 !== inputRules.length) addValidationListener(item, inputRules);
    });

    handleButton();

});

/**
 * Ajout d'un écouteur d'événements pour la validation
 * @param {HTMLElement} item - Le champ du formulaire
 * @param {Array} inputRules
 */
function addValidationListener(item, inputRules) {

    let timeout;

    item.addEventListener('input', function () {

        clearTimeout(timeout);

        timeout = setTimeout(function() {

            handleAlertMessage(item, inputRules);

            handleButton();

        }, 500);
    });

    item.addEventListener('focusout', function () {

        handleAlertMessage(item, inputRules)

    });
}

/**
 *
 * @param {HTMLElement} item
 * @param {Array} inputRules
 */
function handleAlertMessage(item, inputRules) {

    let value = item.value;
    let error = {
        massage: '',
        type: '',
    };


    inputRules.forEach(function(rule) {

        let validationRule = rules[rule];

        if(0 === value.length && 'require' === rule) {
            error.type = 'invalid';
            error.message = rules[rule].message;

        } else if(0 !== value.length && 'require' !== rule) {

            if(rule.startsWith('dateRange')) {

                const parts = rule.split('-');
                const linkedInput = document.getElementById(rule.split('-')[2]);

                linkedInput.setAttribute((parts[1] === 'start') ? 'max' : 'min', value);

            } else if(!validationRule.callback(value)) {

                error.message = validationRule.message;
                error.type = 'error';

            }

        }
    });

    if (Object.values(error).every(value => value === '')) {
        removeAlertMessage(item);
    } else {
        addAlertMessage(item,error);
    }

}

/**
 *
 * @param {HTMLElement} item - Le champ du formulaire
 * @param {Array} error      - Message et type d'erreur
 */
function addAlertMessage(item, error) {
    const inputId = item.id;
    const { message, type } = error;

    let alertDiv = document.getElementById(`Alert${inputId}`);

    if (!alertDiv) {
        item.setAttribute('aria-describedby', `Alert${inputId}`);
        item.setAttribute('aria-invalid', 'true');
        item.classList.add(type);

        alertDiv = document.createElement('div');
        alertDiv.id = 'Alert' + inputId;
        alertDiv.className = `invalid-message ${type}`;
        alertDiv.setAttribute('role', 'alert');
        alertDiv.textContent = message;

        item.insertAdjacentElement('afterend', alertDiv);
    } else {
        item.classList.remove('invalid', 'error');
        item.classList.add(type);

        alertDiv.classList.remove('invalid', 'error');
        alertDiv.classList.add(type);
        alertDiv.textContent = message;
    }

}

/**
 *
 * @param {HTMLElement} item
 */
function removeAlertMessage(item) {
    const inputId = item.id;
    const alertMessage = document.getElementById(`Alert${inputId}`);

    item.removeAttribute('aria-invalid');

    if (alertMessage) {
        item.classList.remove('invalid', 'error');
        alertMessage.remove();
    }

}

function handleButton() {
    const button = document.querySelector('button');
    button.disabled = (countInvalidFields() !== 0);

}

/**
 *
 * @returns {number}
 */
function countInvalidFields() {
    let invalidFields = document.querySelectorAll('[aria-invalid="true"]');
    return invalidFields.length;
}