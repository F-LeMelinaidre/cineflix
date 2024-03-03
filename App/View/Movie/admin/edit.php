<header>
    <h1><?= $title ?></h1>
</header>
<section>
    <form class="film" action="">
        <label class="form-label" for="InputNom">Nom</label>
        <input id="InputNom" class="form-control" type="text" value="<?= $movie->nom ?>">
        <h2>Salle de cinéma</h2>
        <label class="form-label" for="SelectSalle">Salle</label>
        <select id="SelectSalle"  class="form-select">
            <option selected>Selectionner un Cinéma</option>

            <?php foreach($cinemas as $cinema): ?>

                <option value="<?= $cinema->id ?>"><?= ucwords($cinema->nom) ?></option>

            <?php endforeach; ?>

        </select>
        <label class="form-label" for="SelectVille">Ville</label>
        <select id="SelectVille"  class="form-select">
            <option selected>Selectionner une Ville</option>

            <?php foreach($cinemas as $cinema): ?>

                <option value="<?= $cinema->id ?>"><?= ucwords($cinema->nom) ?></option>

            <?php endforeach; ?>

        </select>
        <h2>Date d'exploitation</h2>
        <label class="form-label" for="InputDateDebut">Début</label>
        <input id="InputDateDebut" class="form-control" type="date">
        <label class="form-label" for="InputDateFin">Fin</label>
        <input id="InputDateFin" class="form-control" type="date">
        <label class="form-label" for="TextareaCinopsys">Cinopsys</label>
        <textarea id="TextareaCinopsys" class="form-control" cols="30" rows="8"><?= $movie->cinopsys ?></textarea>
        <label class="form-label" for="InputAffiche">Affiche</label>
        <input id="InputAffiche" class="form-control" type="file">
        <button type="submit" class="btn btn-warning">Ajouter</button>
    </form>
</section>