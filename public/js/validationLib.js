// Validation Email en utilisant la norme RFC2822
const inputs = [];

const rules = {
    minLength: {
        callback: (value, min) => {
            return (min <= value.length);
        },
        message: (min) => `Doit comporter au minimum ${min} caratères`,
    },
    require: {
        callback: (value) => {
            return (0 < value.length);
        },
        message: 'Champs requis !',
    },
    password: {
        callback: (value) => {
            const regex = new RegExp(/^(?=.*[a-zA-Z0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[!?:_\-*#&%+]).{8,}$/);
            return regex.test(value);
        },
        message: '8 caratères minimum, comprenant au minimum une majascule, une minusclule, un chiffre, et un caratère !?:_-*#&%+',
    },
    email: {
        callback: (value) => {
            const regex = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
            return regex.test(value);
        },
        message: 'Votre email ne respete pas la norme RFC2822',
    }
}

document.addEventListener('DOMContentLoaded', function () {

    const items = document.querySelectorAll('input, textarea');

    let invalidInputs = [];

    let position = 0;
    items.forEach(function (item, i) {







        inputs[item.name] = inputs[item.name] || {};

        inputs[item.name] = {
            position: position++,
            require: ('true' === item.getAttribute('aria-required')) ?  rules.require : null,
            validation: ('password' === item.type || 'email' === item.type) ? rules[item.type] : null,
            minLength: (item.getAttribute('min')) ? rules.minLength : null,

        };
    });

    console.dir(inputs);
});