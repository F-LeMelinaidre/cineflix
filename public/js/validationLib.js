
// Validation Email en utilisant la norme RFC2822
function isEmail($element) {
    const regex = new RegExp(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);
    return regex.test($element.val());
}

$(document).ready(function() {
    $('[data-val]').each(function() {
        const $this = $(this);
        const method = $this.data('val'); // Ensure method name matches function name

        $this.on('blur', function() {
            if (!window[method]($this)) { // Ensure function is defined
                alert('Champ invalide!');
            }
        });
    });
});