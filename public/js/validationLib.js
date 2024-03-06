
// Validation Email en utilisant la norme RFC2822

function isRequired($element) {
    return $element.val().length();
}
function validationMail($element) {
    const regex = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
    return regex.test($element.val());
}

function validationPassword($element) {
    return false;
}

$(document).ready(function() {
    $('[aria-describedby]').each(function() {
        const $this = $(this);
        const describedById = $this.attr('aria-describedby');

        if (describedById && $(`#${describedById}`).length) {
            const validationMethod = $(`#${describedById}`)[0].id;
            $this.on('blur', function() {
                let value = $this.val();

                if (!value.length) {
                    $this.addClass('invalid');
                } else if (!window[validationMethod]($this)) {
                    $this.addClass('error');
                    $this.removeClass('invalid');
                } else {
                    $this.removeClass('invalid error');
                }
            });
        }
    });
});