<header>
    <h1><?= $title ?></h1>
</header>
<section>
    <form class="film" action="<?= self::$_Router->getUrl('admin_movie_edit') ?>" method="post">
        <label class="form-label" for="InputNom">Nom</label>
        <input id="InputNom" class="form-control" type="text" value="<?= $movie->nom ?>">

        <label class="form-label" for="SelectSalle">Salle de cinéma</label>

        <input id="SelectSalle" class="form-select" name="SelectSalle" type="text" list="SalleList" value="<?= $movie->cinema.' - '.$movie->ville ??
            '' ?>"
               placeholder="Saisissez une ville ou un Cinéma" autocomplete="on">

        <datalist id="SalleList">
            <option value="<?= $movie->cinema?>" >

        </datalist>

        <h2 class="date-exploitation">Date d'exploitation</h2>
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
<script src="/public/js/jquery-3.7.1.min.js"></script>
<script>
    let salle = document.querySelector('#SelectSalle');

    function debounce(callback, delay) {
        let timeout = null;

        return function() {
            let item = this;
            let args = arguments;
            clearTimeout(timeout)

            timeout = setTimeout(function() {
                callback.apply(item, args);
            }, delay)

        }
    }

    salle.addEventListener('keyup', debounce(function(){
        if(this.value.length > 3 && this.value) {
            let salle = this.value;
            let val = '/Ajax/'+encodeURIComponent(salle);
            $.ajax({
                url: val,
                method: 'GET',
                success: function(data) {
                    console.log(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Handle errors (optional)
                    console.error("Error:", textStatus, errorThrown);
                }
            });
        }

    },500))

</script>