$(document).ready(function () {

    $('#SubmitButton').attr('disabled','disabled');

    // Récupérer toutes les balises <script> avec l'attribut data-function
    $('script[data-function]').each(function() {
       let functionName = $(this).attr('data-function');

       // Active les differentes fonctions appelées
        switch (functionName) {
            case 'MovieSearch':
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
    $('#InputNom').on('input', function () {
        let value = $(this).val().trim();

        // Vérifier si la valeur de l'entrée correspond à un nom de film dans la list
        let found = list.some(movie => movie === value);

        // Si la valeur de l'entrée ne correspond à aucun nom de film dans la list, vider les champs associés
        if (!found) {

            //$('#InputDateSortie').val('');

            //$('#TextareaSynopsis').text('');

            //$('.thumb').attr('src', '').addClass('hidden');

            $('.form-message').text('').addClass('hidden');
            $('#fiche_id').val('');
        }
    });

    $('#InputNom').autocomplete({

        minLength: 2,
        delay: 500, // Utilisation du paramètre de délai intégré à l'autocomplétion
        appendTo: '#MoviesList',
        source: function(request, response) {
            let value = request.term;

            $.ajax({
                url: '/Ajax/filmSearch',
                method: 'POST',
                data: {
                    nom: value,
                },
                success: function (data) {
                    if (data.trim() !== "") {
                        list = JSON.parse(data);
                        let noms = list.map(list.nom);
                        response(noms);
                    }
                }
            });

        },
        select: function(event, ui) {
            let value = ui.item.value;
            let props = list.find(movie => movie.nom === value);

            $('#InputDateSortie').val(props.date_sortie);

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