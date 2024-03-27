<header class="d-flex
                       justify-content-around
                       align-items-center
                       position-relative
                       mt-4
                       border-top border-bottom border-dark">
    <h1 class="flex-grow-1 ms-5"><?= ucfirst($movie->nom) ?></h1>
    <span>Sortie le <date class="me-5"><?= $movie->date_sortie ?></date></span>
</header>
<section class="container justify-content-center row-gap-4 column-gap-4 flex-wrap mt-4">
    <h1>Synopsis</h1>
    <img src="<?= '../'.$movie->affiche ?>" height="440">
    <p><?= $movie->synopsis ?></p>
</section>