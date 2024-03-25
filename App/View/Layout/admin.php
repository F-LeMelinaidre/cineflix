<header id="AdminHeader" class="container-fluid p-0">
    <h1>Administration <span>(brouillon)</span></h1>

</header>
<main id="AdminContent" class="container-fluid p-0">
    <nav class="breadcrumb">
        <ul>
            <li>Accueil</li>
            <li>Film</li>
            <li>Ajouter</li>
        </ul>
        <span>(brouillon)</span>
    </nav>
    <aside>

        <nav class="main-menu">
            <ul>

               <?php if ($page == 'movie_index'){  ?>

                <li>Film</li>
                <?php } else { ?>
                <li><a href="<?= self::$_Router->getUrl("admin_movie_index") ?>">Films</a></li>
<?php } ?>
                <li><a href="<?= self::$_Router->getUrl("admin_streaming_index") ?>">Streamings</a></li>

                <li><a href="<?= self::$_Router->getUrl("admin_cinema_index") ?>">Cinémas</a></li>

                <li><a href="<?= self::$_Router->getUrl("admin_user_index") ?>">Membres</a></li>

            </ul>
        </nav>
    </aside>

    {{content}}

</main>