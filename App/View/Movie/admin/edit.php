<header>
    <h1><?= $title ?></h1>
</header>
<section>
    <form class="film" action="">
        <label class="form-label" for="InputNom">Nom</label>
        <input id="InputNom" class="form-control" type="text" value="<?= $movie->nom ?>">
        <h2>Date d'exploitation</h2>
        <label class="form-label" for="InputDateDebut">Début</label>
        <input id="InputDateDebut" class="form-control" type="date">
        <label class="form-label" for="InputDateFin">Fin</label>
        <input id="InputDateFin" class="form-control" type="date">
        <label class="form-label" for="SelectSalle">Salle</label>
        <select id="SelectSalle"  class="form-select">
            <option selected>Selectionner une ville</option>
            <option value="">Auray</option>
            <option value="">Vannes</option>
        </select>
        <label class="form-label" for="TextareaCinopsys">Cinopsys</label>
        <textarea id="TextareaCinopsys" class="form-control" cols="30" rows="10"><?= $movie->cinopsys ?></textarea>
        <label class="form-label" for="InputAffiche">Affiche</label>
        <input id="InputAffiche" class="form-control" type="file">
        <button type="submit" class="btn btn-warning">Ajouter</button>
    </form>
</section>