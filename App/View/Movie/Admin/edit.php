<header>
    <h1><?= $title ?></h1>
</header>
<section>
  
    <form class="film" action="<?= $url ?>" method="post">
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
        <div class="file-name"></div>
        <button type="submit" class="btn btn-warning">Ajouter</button>
    </form>
</section>
<script src="/public/js/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {

        $('#InputNom').keyup(function() {

            var delay = 500;
            var timer = setTimeout(function() {
// stocker le select dans une const
                if ($('#InputNom').val().length >= 3) {
                    $.ajax({
                        url: '/Ajax/filmSearch',
                        method: 'POST',
                        data: {
                            nom: $('#InputNom').val(),
                        },
                        success: function(response) {

                            if (response != false) {
                                let rep = JSON.parse(response);
                                $('#InputNom').val(rep.nom);
                                $('#TextareaCinopsys').text(rep.cinopsys);

                                $('#InputDateSortie').val(rep.date_sortie);
                                $('.file-name').text(getFileName(rep.affiche));
                            }
                        }
                    });
                }
            }, delay);

            $(this).on('keydown', function() {
                clearTimeout(timer);
            });

            function getFileName(path) {
                const segments = path.split("/");
                const fileName = segments[segments.length - 1];

                return fileName;
            }
        });

    });
</script>