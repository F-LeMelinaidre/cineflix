<header class="d-flex
               justify-content-around
               align-items-center
               position-relative
               mt-4
               border-top border-bottom border-dark">
    <h1>Mon Profil</h1>
    <p>Dernière connection</p>
    <a href="<?= self::$_Router->getUrl("profil_edit") ?>" class="btn btn-sm btn-outline-warning me-lg-5">Modifier</a>
</header>

<section id="Profil" class="container d-flex justify-content-center row-gap-4 column-gap-4 flex-wrap mt-4">
    <dl>
        <dt>Nom :</dt>
        <dd> mon nom</dd>
        <dt>Prénom :</dt>
        <dd>Mon prénom</dd>
        <dt>Email :</dt>
        <dd>monadresse@mail.com</dd>
        <dt>N° :</dt>
        <dd>1</dd>
        <dt>Voie :</dt>
        <dd>rue</dd>
        <dt>Nom de la voie :</dt>
        <dd>lavoie</dd>
        <dt>Code postale :</dt>
        <dd>00000</dd>
        <dt>Ville :</dt>
        <dd>ma ville</dd>
    </dl>
</section>