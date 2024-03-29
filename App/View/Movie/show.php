
    <section id="Film" class="row col-xl-6 col-lg-7 col-md-10 col-sm-12 mt-md-4 my-lg-0 my-sm-0 p-0 m-0">
        <div class="col-sm-6">
            <header>
                <h1><?= ucfirst($movie->nom) ?></h1>
                <span>Sortie le <date class="me-5"><?= $movie->date_sortie ?></date></span>
            </header>
            <h2>Synopsis</h2>
            <p><?= $movie->synopsis ?></p>
        </div>
        <div class="col-sm-6">
            <img class="affiche" src="<?= '../' . $movie->affiche ?>">
        </div>

    </section>
    <section id="Cinema" class="row col col-lg-3 col-md-10 col-sm-12 mb-md-4 my-lg-0 my-sm-0 p-0 m-0">
        <header>
            <h1><?= $movie->cinema ?></h1>
            <h2><?= $movie->ville ?></h2>
        </header>
        <h3>Séance</h3>
        <ul>
            <?php foreach($seances as $seance) { ?>

                <li><?= $seance['date']. ' - ' .$seance['horaire'] ?></li>

            <?php } ?>
        </ul>
    </section>

