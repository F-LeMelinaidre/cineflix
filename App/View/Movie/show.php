
    <section id="Film" class="row col-xl-6 col-lg-7 col-md-10 col-sm-12">
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
    <section id="Cinema" class="row col-xl-3 col-lg-3 col-md-10 col-sm-12">
        <header>
            <h1><?= $movie->cinema ?></h1>
            <h2><?= $movie->ville ?></h2>
        </header>
        <div id="Seance">
            <h3>Séance</h3>
            <ul class="seance-list row gap-3 justify-content-between align-content-center align-items-end">
                <?php foreach($seances as $seance) { ?>

                    <li class="card col"><?= $seance['date']. ' - ' .$seance['horaire'] ?></li>

                <?php } ?>
            </ul>
        </div>

    </section>

