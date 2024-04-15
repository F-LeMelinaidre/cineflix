<header class="d-flex
                       justify-content-around
                       align-items-center
                       position-relative
                       mt-4
                       border-top border-bottom border-dark">
    <h1 class="flex-grow-1 ms-5 mb-0">Films en salles</h1>
</header>
<section class="container d-flex justify-content-center row-gap-4 column-gap-4 flex-wrap mt-4">

    <?php foreach($streams as $stream): ?>

        <div class="card card-info">
            <div class="bill-container">
                <a href="<?= self::$_Router->getUrl("streaming_show",['slug' => $stream->slug]) ?>">
                    <img src="<?= $stream->affiche ?>" alt="la bête" class="bill card-img-top">
                </a>
            </div>
            <div class="card-body border-top py-1">
                <h5 class="card-title">
                    <a href="<?= self::$_Router->getUrl("streaming_show",['slug' => $stream->slug]) ?>" class="link-warning link-offset-1
                link-underline-opacity-50
                link-underline-opacity-100-hover text-capitalize">
                        <?= $stream->nom ?>
                    </a>
                </h5>
                <ul class="card-text">
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>

    <?php endforeach; ?>

</section>