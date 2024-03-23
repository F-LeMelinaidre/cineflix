<header>
    <h1><?= $title ?></h1>
    <p>Ville <span id="txtShow"></span></p>
</header>
<section>
    <form class="film" action="<?= self::$_Router->getUrl('admin_movie_edit') ?>" method="post">
        <label class="form-label" for="InputNom">Nom</label>
        <input id="InputNom" class="form-control" type="text" value="<?= $movie->nom ?>">
        <h2>Salle de cinéma</h2>
        <label class="form-label" for="SelectSalle">Salle</label>
        <select id="SelectSalle" class="form-select" contenteditable="true">
            <option selected>Selectionner un Cinéma</option>

            <?php foreach($cinemas as $cinema): ?>

                <option value="<?= $cinema->id ?>"><?= ucwords($cinema->nom) ?></option>

            <?php endforeach; ?>

        </select>
        <label class="form-label" for="SelectVille">Ville</label>

        <input id="SelectVille" class="form-select" name="SelectVille" type="text" list="VilleList" value="<?= $ville ?? '' ?>"
               placeholder="Saisissez une ville" autocomplete="on">

            <datalist id="VilleList">
                <?php
                $t = "Carnac";
                foreach ($villes as $ville):
                ?>
                <option value="<?= $ville->nom?>" >
                    <?php
                    endforeach;
                    ?>
            </datalist>

        <!-- <select id="SelectVille"  class="form-select" onchange="showSelect(this.value)">
            <option selected>Selectionner une Ville</option>


        </select> -->
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
<script>
    function showSelect(str) {
        if(0 == str.length) {
            document.getElementById('txtShow').innerHtml = "";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (4 == this.readyState && 200 == this.status) {
                    document.getElementById('txtShow').innerHTML = this.responseText;
                }
            };
            xmlhttp.open('GET', 'http://cineflix-2/Api/SelectTown/' + str, true);
            xmlhttp.send();
        }
    }
</script>