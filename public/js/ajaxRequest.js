$(document).ready(function () {
    let rep = []; // Définir le tableau rep en dehors de la fonction pour qu'il soit accessible dans tout le code

    $('#InputNom').on('input', function () {
        let movieValue = $(this).val().trim();

        // Vérifier si la valeur de l'entrée correspond à un nom de film dans le tableau rep
        let found = rep.some(movie => movie === movieValue);

        // Si la valeur de l'entrée ne correspond à aucun nom de film dans le tableau rep, vider les champs associés
        if (!found) {
            $('#InputDateSortie').val('');
            $('#TextareaCinopsys').text('');
            $('.thumb').attr('src', '').addClass('hidden');
        }
    });

    // debounce applique un delay lors de la saisie avant d'envoyer la requete ajax
    $('#InputNom').on('keyup', debounce(function () {

        let $inputMovie = $(this);
        let movieValue = $inputMovie.val();


        $.ajax({
            url: '/Ajax/filmSearch',
            method: 'POST',
            data: {
                nom: movieValue,
            },
            success: function (response) {

                if (response.trim() !== "") {
                    rep = JSON.parse(response);

                    let movieNames = rep.map(getMovieName);

                    $inputMovie.autocomplete({
                        minLength: 2,
                        appendTo: '#MoviesList',
                        source: movieNames,
                        select: function (event, ui) {

                            // Lorsqu'un film est sélectionné depuis l'autocomplete
                            let selectedMovieName = ui.item.value; // Récupérer le nom du film sélectionné

                            // Rechercher dans rep pour trouver les autres informations du film
                            let selectedMovieInfo = rep.find(movie => movie.nom === selectedMovieName);
                            $('#InputDateSortie').val(selectedMovieInfo.date_sortie);
                            $('#TextareaCinopsys').text(selectedMovieInfo.cinopsys);
                            $('.thumb img').attr('src', '../../' + selectedMovieInfo.affiche);
                            $('.thumb').removeClass('hidden');
                        }
                    });
                } else {
                    $('#InputDateSortie').val('');
                    $('#TextareaCinopsys').text('');
                    $('.thumb').attr('src', '').addClass('hidden');
                }


            }
        });


    }, 200));
});

// reinitialise le timer
function debounce(callback, delay) {
    let timer = null;

    return function () {
        let item = $(this);
        let args = arguments; //tableau des parametres de la function racine
        clearTimeout(timer)
        timer = setTimeout(function () {
            callback.apply(item, args);
        }, delay)
    }
}

function getMovieName(movie) {
    return movie.nom;
}