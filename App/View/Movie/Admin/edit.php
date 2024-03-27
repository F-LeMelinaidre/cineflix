<header>
    <h1><?= $title ?></h1>
</header>
<section>
  
    <form class="film" action="<?= $url ?>" method="post">
        <div class="form-message hidden"></div>
        <h2 class="titre">Information du film</h2>
  
        <label class="form-label" for="InputNom">Nom</label>
        <input id="InputNom" class="form-control" type="text" name="nom" value="<?= $movie->nom ?>" aria-required="true">
        <div id="MoviesList"></div>

        <label class="form-label" for="InputDateSortie">Date de sortie</label>
        <input id="InputDateSortie" class="form-control" type="date" name="date_sortie" value="<?= $movie->date_sortie ?>" aria-required="true">

        <label class="form-label" for="InputCinema">Cinema</label>
        <input id="InputCinema" class="form-select" type="text" name="cinema" value="<?= '$movie->cinema->nom $movie->ville->nom' ?>"
               placeholder="Saisissez un cinéma ou une ville" aria-required="true">
        <div id="CinemasList"></div>
        <input type="hidden" id="cinema_id" name="cinema_id" value="">

        <h2 class="exploitation">Information d'exploitation</h2>
        <label class="form-label" for="InputDateDebut">Début</label>
        <input id="InputDateDebut" class="form-control" type="date" name="exploitation_debut" value="<?= '$movie->exploitation_debut' ?>" aria-required="true">
        <label class="form-label" for="InputDateFin">Fin</label>
        <input id="InputDateFin" class="form-control" type="date" name="exploitation_fin" value="<?= '$movie->exploitation_fin' ?>" aria-required="true">

        <label class="form-label" for="TextareaSynopsis">Synopsis</label>
        <textarea id="TextareaSynopsis" class="form-control" name="synopsis" cols="30" rows="5" aria-required="true"><?= $movie->synopsis ?></textarea>

        <label class="form-label" for="InputAffiche">Affiche</label>
        <input id="InputAffiche" class="form-control" name="affiche" type="file" accept=".png, .jpg, .jpeg" aria-required="true">
        <div class="thumb"><img src="" alt="" width="120px"></div>

        <input type="hidden" id="fiche_id" name="fiche_id" value="">
        <button id="SubmitButton" class="btn btn-warning" type="submit">Ajouter</button>
    </form>
</section>
<script src="/public/js/jquery-3.7.1.min.js"></script>
<script src="/public/js/jquery-ui.min.js"></script>
<script src="/public/js/ajaxRequest.js" data-function="MovieSearch"></script>
<script src="/public/js/ajaxRequest.js" data-function="CinemaSearch"></script>
<script src="/public/js/validationLib.js"></script>