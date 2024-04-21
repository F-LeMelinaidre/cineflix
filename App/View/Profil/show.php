<section  id="Profil" class="p-0">
    <header class="d-flex
               justify-content-between
               align-items-center
               position-relative
               mt-4
               border-top border-bottom border-dark">
        <h1 class="ms-5">Mon Profil</h1>
        <p>Dernière connection</p>
    </header>

    <div class="col-xl-8 col-lg-9 col-md-11 col-sm-12 row mt-4 m-auto p-4 pt-3 rounded-2 bg-dark-subtle">
        <h2 class="p-0 mb-2">Identité</h2>
        <dl class="identite-view row row-gap-2 align-items-center mb-4">
            <dt class="col-2 text-end pe-2">Nom :</dt>
            <dd class="col-3"><?= $profil->nom ?></dd>
            <dt class="col-4 text-end pe-2">Date de naissance :</dt>
            <dd class="col-3"><?= $profil->date_naissance ?></dd>
            <dt class="col-2 text-end pe-2">Prénom :</dt>
            <dd class="col-3"><?= $profil->prenom ?></dd>
        </dl>
        <h2 class="p-0 mb-2">Coordonnées</h2>
        <dl class="contact-view row row-gap-2 align-items-center">
            <dt class="col-2 text-end pe-2">Email :</dt>
            <dd class="col-10"><?= $profil->user->email ?></dd>
            <dt class="col-2 text-end pe-2">Adresse postale :</dt>
            <dd class="col-10"><?= $profil->getAddress() ?></dd>
            <dt class="col-2 text-end pe-2">Code postale :</dt>
            <dd class="col-1"><?= $profil->code_postale ?></dd>
            <dt class="col-1 text-end pe-2">Ville :</dt>
            <dd class="col-8"><?= $profil->ville ?></dd>
        </dl>
        <a href="<?= self::$_Router->getUrl("profil_edit") ?>" class="col-auto ms-auto btn btn-sm btn-outline-warning mt-3">Modifier</a>
    </div>

</section>