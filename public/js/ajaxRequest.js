$(document).ready(function () {

    // Récupérer toutes les inputs avec l'attribut data-action
    $('input[data-action]').each(function() {

        // ajout un ecouteur sur les inputs avec l'attribut data-action
        $(this).on('input', function() {
            // Récupère l'action
            let action = $(this).data('action');

            // Active la methode correspondant a la valeur de data-action
            switch (action) {
                case 'movieSearch':
                    MovieSearch();
                    break;
                case 'cinemaSearch':
                    CinemaSearch();
                    break;

                default:
                    console.error('Fonction inconnu');
            }

        });

    });

    $('button[data-token]').click(function() {
        console.log($(this).attr('data-token'));
    });

});

function CinemaSearch() {
    let list = [];

    $('#InputCinema').autocomplete({

        minLength: 3,
        delay: 500, // Utilisation du paramètre de délai intégré à l'autocomplétion
        appendTo: '#CinemasList',
        source: function(request, response) {
            let value = request.term;

            $.ajax({
                url: '/Ajax/cinemaSearch',
                method: 'GET',
                data: {
                    nom: value,
                },
                success: function (data) {

                    if (data.trim() !== "") {
                        list = JSON.parse(data);
                        let cinemas = list.map(item => item.nom + ' - ' + item.ville.nom);
                        response(cinemas);

                    }
                }
            });
        },
        select: function(event, ui) {
            let value = ui.item.value;
            // On eclate la chaine de caratere pour récupérer seulement le nom
            let nom = value.split(' - ');
            nom = nom[0];

            // Récupérer l'ID du cinéma sélectionné avec son nom
            let props = list.find(cinema => cinema.nom === nom);
            let id = props.id;
            // Affecter l'ID à l'input hidden
            $('#cinema_id').val(id);

        }
    });
}
function MovieSearch() {
    let movies = [];
    let movieStatus = [];
    let item = $('#InputFilmNom');

    item.on('input', function () {
        let value = $(this).val().trim();
        let found = movies.some(movie => movie === value);
    });

    item.autocomplete({

        minLength: 2,
        delay: 500, // Utilisation du paramètre de délai intégré à l'autocomplétion
        appendTo: '#MoviesList',
        source: function(request, response) {
            let value = request.term;



            $.ajax({
                url: '/Ajax/movieSearch',
                method: 'GET',
                data: {
                    nom: value,
                },
                success: function (data) {
                    let list;
                    if (data.trim() !== "") {
                        list = JSON.parse(data);

                        movies = list.movies;
                        movieStatus = list.movieStatus;

                        let noms = movies.map(item => item.nom);
                        response(noms);
                    }
                }
            });

        },
        select: function(event, ui) {

            let value = ui.item.label; // Accéder directement à la propriété nom
            let props = movies.find(movie => movie.nom === value);

        }
    });


}


/**
 * @param {Json} status
 * @param {integer} statusId
 */
function setAlertInfo(statusId, status) {
    let label = status[statusId];
    if(1>=statusId) {
        addAlertInfo(label)
    }

}

/**
 *
 * @param {string} label
 */
function addAlertInfo(label) {
    const infoAlert = $(`<div class="info-alert">Ce film est déjà proposé ${label}!</div>`);

    $('form').append(infoAlert);
    infoAlert.hide().fadeIn(500);

    $('#AddButton').prop('disabled', true);
}

/**
 *
 */
function removeAlertInfo() {
    const $infoAlert = $('.info-alert');
    if($infoAlert) {
        $infoAlert.fadeOut(500, function() {
            $(this).remove();
        });
    }

}


/**
 *
 * @param date
 * @returns {string}
 */
function formatDate(date) {
    let dateParts = date.split(' ')[0].split('-');
    return `${dateParts[0]}-${dateParts[1]}-${dateParts[2]}`;
}