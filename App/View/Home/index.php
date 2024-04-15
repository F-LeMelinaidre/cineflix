<header class="d-flex
               justify-content-around
               align-items-center
               p-0
               mt-4
               border-top border-bottom border-dark">
    <h1 class="flex-grow-1 ms-5 mb-0">Films en salles</h1>
</header>
<section class="container d-flex justify-content-center row-gap-4 column-gap-4 flex-wrap mt-4">
    <nav class="col-12 d-flex ms-5 align-items-center">
        <input type="text" class="form-control w-25 m-0">
        <a href="#" class="btn btn-sm btn-outline-warning ms-4">Rechercher</a>
    </nav>
    <?php foreach($movies as $movie): ?>

    <div class="card card-info">
        <div class="bill-container">
            <a href="<?= self::$_Router->getUrl("movie_show",['slug' => $movie->slug]) ?>">
                <img src="<?= $movie->affiche ?>" alt="la bête" class="bill card-img-top">
            </a>
        </div>
        <div class="card-body border-top py-1">
            <h5 class="card-title">
                <a href="<?= self::$_Router->getUrl("movie_show",['slug' => $movie->slug]) ?>" class="link-warning link-offset-1
                link-underline-opacity-50
                link-underline-opacity-100-hover text-capitalize">
                    <?= $movie->nom ?>
                </a>
            </h5>
            <ul class="card-text">
                <li><?= $movie->cinema ?></li>
                <li><?= $movie->ville ?></li>
            </ul>
        </div>
    </div>

    <?php endforeach; ?>

</section>