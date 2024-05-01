$(document).ready(function () {

    $('#SubmitButton').attr('disabled','disabled');

    // Récupérer toutes les inputs avec l'attribut data-action
    $('input[data-action]').each(function() {

        console.log($(this));
        // ajout un ecouteur sur les inputs avec l'attribut data-action
        $(this).on('input', function() {
            // Récupère l'action
            let action = $(this).data('action');

            // Active la methode correspondant a la valeur de data-action
            switch (action) {
                case 'movieSearch':
                    MovieSearch();
                    break;
                case 'CinemaSearch':
                    CinemaSearch();
                    break;

                default:
                    console.error('Fonction inconnu');
            }

        });

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
                method: 'POST',
                data: {
                    cinema: value,
                },
                success: function (data) {

                    if (data.trim() !== "") {
                        list = JSON.parse(data);
                        let cinemas = list.map(item => item.nom + ' - ' + item.ville);
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
    let list = [];
    let item = $('#InputNom');

    item.on('input', function () {
        let value = $(this).val().trim();

        // Vérifier si la valeur de l'entrée correspond à un nom de film dans la list
        let found = list.some(movie => movie === value);

        // Si la valeur de l'entrée ne correspond à aucun nom de film dans la list, vider les champs associés
        if (!found) {

            $('#InputDateSortie').val('');

            $('#TextareaSynopsis').text('');

            $('.thumb').attr('src', '').addClass('hidden');

            $('.form-message').text('').addClass('hidden');
            $('#fiche_id').val('');
        }
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
                    if (data.trim() !== "") {
                        list = JSON.parse(data);
                        let noms = list.map(item => item.nom);
                        response(noms);
                    }
                }
            });

        },
        select: function(event, ui) {

            let value = ui.item.value;
            let props = list.find(movie => movie.nom === value);

            console.log(props);
            $('#InputDateSortie').val(formatDate(props.date_sortie));
            $('#InputDateDebut').val(formatDate(props.exploitation.debut));
            $('#InputDateFin').val(formatDate(props.exploitation.fin));

            $('#InputCinema').val(`${props.cinema.nom} - ${props.cinema.ville.nom}`);

            $('#TextareaSynopsis').text(props.synopsis);

            $('.thumb img').attr('src', '../../' + props.affiche);

            $('#fiche_id').val(props.id);

            $('.thumb').removeClass('hidden');

            if (null != props.film_id) {
                $('.form-message').text('Ce film est déjà proposé en salle!').removeClass('hidden');
            }
        }
    });


}
function formatDate(date) {
    let dateParts = date.split(' ')[0].split('-');
    return dateParts[0] + '-' + dateParts[1] + '-' + dateParts[2];
}