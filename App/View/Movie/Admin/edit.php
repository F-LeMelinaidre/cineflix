<header>
    <h1><?= $title ?></h1>
</header>
<section>
  
    <form class="film" action="<?= $url ?>" method="post">
        <div class="form-message hidden"></div>
        <h2 class="titre">Information du film</h2>
  
        <label class="form-label" for="InputNom">Nom</label>
        <input id="InputNom" class="form-control" type="text" name="nom" value="<?= $movie->nom ?>">

        <label class="form-label" for="InputDateSortie">Date de sortie</label>
        <input id="InputDateSortie" class="form-control" name="date_sortie" type="date">

        <label class="form-label" for="SelectCinema">Cinema</label>

        <input id="SelectCinema" class="form-select" name="cinema" type="text" list="CinemaList" value="<?= $movie->cinema. ' ' .$movie->ville ?? '' ?>"
               placeholder="Saisissez un cinéma" autocomplete="on">

            <datalist id="CinemaList">

            </datalist>

        <h2 class="exploitation">Information d'exploitation</h2>
        <label class="form-label" for="InputDateDebut">Début</label>
        <input id="InputDateDebut" class="form-control" type="date">
        <label class="form-label" for="InputDateFin">Fin</label>
        <input id="InputDateFin" class="form-control" type="date">

        <label class="form-label" for="TextareaCinopsys">Cinopsys</label>
        <textarea id="TextareaCinopsys" class="form-control" name="cinopsys" cols="30" rows="5"><?= $movie->cinopsys ?></textarea>

        <label class="form-label" for="InputAffiche">Affiche</label>
        <input id="InputAffiche" class="form-control" name="affiche" type="file" accept=".png, .jpg, .jpeg">
        <div class="thumb hidden"><img src="" alt="" width="120px"></div>
        <button id="SubmitButton" class="btn btn-warning" type="submit">Ajouter</button>
    </form>
</section>
<script src="/public/js/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#SubmitButton').attr('disabled','disabled');

        $("#InputNom").autocomplete({
            source: [], // Initially empty source
            minLength: 2
        });
        let timer;
        const delay = 500;

        $('#InputNom').keyup(function() {

            clearTimeout(timer);
            timer = setTimeout(function() {
                if ($('#InputNom').val().length >= 2) {
                    $.ajax({
                        url: '/Ajax/filmSearch',
                        method: 'POST',
                        data: {
                            nom: $('#InputNom').val(),
                        },
                        success: function (response) {
                            if (response != false) {
                                let rep = JSON.parse(response);
                                if (null != rep.film_id) {
                                    $('.form-message').text('Ce film est déjà proposé en salle!');
                                    $('.form-message').removeClass('hidden');
                                }
                                let movieNames = rep.map(getMovieName);
                                $("#InputNom").autocomplete("option", "source", movieNames);

                                $('#TextareaCinopsys').text(rep.cinopsys);

                                $('#InputDateSortie').val(rep.date_sortie);
                                $('.thumb img').attr('src', '../../' + rep.affiche);
                                $('.thumb').removeClass('hidden');
                            }
                        }
                    });

            }else {
                    //if($('#InputDateSortie').val().length > 0) $('#InputDateSortie').val("");
                    //if($('#TextareaCinopsys').text().length > 0) $('#TextareaCinopsys').text("");

                    //if (!$('.form-message').hasClass("hidden")) $('.form-message').addClass('hidden');
                    //if (!$('.thumb').hasClass("hidden")) $('.thumb').addClass('hidden');

                    //if($('#InputDateSortie').val().length > 0) $('#InputDateSortie').val("");
                    //if($('#InputDateSortie').val().length > 0) $('#InputDateSortie').val("");
                }
            }, delay);


            $(this).on('keydown', function() {
                clearTimeout(timer);
            });

            function getMovieName(movie) {
                return movie.nom;
            }

            function getFileName(path) {
                const segments = path.split("/");
                const fileName = segments[segments.length - 1];

                return fileName;
            }
        });

    });
</script>