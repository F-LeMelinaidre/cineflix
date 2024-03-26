<header>
    <h1><?= $title ?></h1>
</header>
<section>
  
    <form class="film" action="<?= $url ?>" method="post">
        <div class="form-message hidden"></div>
        <h2 class="titre">Information du film</h2>
  
        <label class="form-label" for="InputNom">Nom</label>
        <input id="InputNom" class="form-control" type="text" list="datalistMovies" name="nom" value="<?= $movie->nom ?>">
        <div id="MoviesList"></div>
        <label class="form-label" for="InputDateSortie">Date de sortie</label>
        <input id="InputDateSortie" class="form-control" name="date_sortie" type="date">

        <label class="form-label" for="SelectCinema">Cinema</label>

        <input id="SelectCinema" class="form-select" name="cinema" type="text" list="CinemaList" value="<?= $movie->cinema. ' ' .$movie->ville ?? '' ?>"
               placeholder="Saisissez un cinéma" autocomplete="on">
        <div id="CinemasList"></div>

        <h2 class="exploitation">Information d'exploitation</h2>
        <label class="form-label" for="InputDateDebut">Début</label>
        <input id="InputDateDebut" class="form-control" type="date">
        <label class="form-label" for="InputDateFin">Fin</label>
        <input id="InputDateFin" class="form-control" type="date">

        <label class="form-label" for="TextareaCinopsys">Cinopsys</label>
        <textarea id="TextareaCinopsys" class="form-control" name="cinopsys" cols="30" rows="5"><?= $movie->cinopsys ?></textarea>

        <label class="form-label" for="InputAffiche">Affiche</label>
        <input id="InputAffiche" class="form-control" name="affiche" type="file" accept=".png, .jpg, .jpeg">
        <div class="thumb"><img src="" alt="" width="120px"></div>
        <button id="SubmitButton" class="btn btn-warning" type="submit">Ajouter</button>
    </form>
</section>
<script src="/public/js/jquery-3.7.1.min.js"></script>
<script src="/public/js/jquery-ui.min.js"></script>
<script src="/public/js/ajaxRequest.js" data-function="MovieSearch"></script>