<header>
    <h1><?= $title ?></h1>
    <p>Ville <span id="txtShow"></span></p>
</header>
<section>
    <form class="film" action="<?= self::$_Router->getUrl('admin_streaming_edit') ?>" method="post">
        <label class="form-label" for="InputNom">Nom</label>
        <input id="InputNom" class="form-control" type="text" value="<?= $stream->nom ?>">
        <label class="form-label" for="TextareaCinopsys">Cinopsys</label>
        <textarea id="TextareaCinopsys" class="form-control" cols="30" rows="8"><?= $stream->cinopsys ?></textarea>
        <label class="form-label" for="InputAffiche">Affiche</label>
        <input id="InputAffiche" class="form-control" type="file">
        <button type="submit" class="btn btn-warning">Ajouter</button>
    </form>
</section>