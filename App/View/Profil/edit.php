<section  id="Profil" class="p-0">
    <header class="d-flex justify-content-around align-items-center mt-4 border-top border-bottom border-dark">
        <h1>Éditer mon Profil</h1>
        <p>Dernière modification</p>
        <a href="<?= self::$_Router->getUrl("profil_show") ?>" class="btn btn-sm btn-outline-warning me-lg-5">Retour</a>
    </header>

    <form action="<?= self::$_Router->getUrl('profil_edit') ?>" method="post"  class="edit-profil mt-4 m-auto p-4 rounded-2 bg-dark-subtle">
        <div id="Identity" class="mb-4">
            <h2 class="mb-3">Identité :</h2>
            <div class="row justify-content-center">
                <div class="col-md-6 col-sm-6 col-12">
                    <label class="nom col-6" for="Nom">Nom :</label>
                    <input id="Nom" type="text" name="nom" value="<?= $profil->nom ?>" class="form-control mb-3">
                </div>
                <div class="col-md-6 col-sm-6 col-12">
                    <label class="prenom col-6" for="Prenom">Prénom :</label>
                    <input id="Prenom" type="text" name="prenom" value="<?= $profil->prenom ?>" class="form-control
                    mb-3">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8 col-sm-8 col-12">
                    <label class="email" for="Email">Email :</label>
                    <input id="Email" type="email" name="email" value="<?= $profil->user->email ?>" class="form-control
                    mb-3">
                </div>
                <div class="col-md-4 col-sm-4 col-12">
                    <label class="date-de-naissance" for="DateNaissance">Date de naissance :</label>
                    <input id="DateNaissance" type="date" name="date_naissance" value="<?= $profil->date_naissance ?>"
                           class="form-control
                    mb-3">
                </div>
            </div>
        </div>

        <div id="Address">
            <h2 class="mb-3">Adresse :</h2>
            <div class="row justify-content-center">
                <div class="col-md-2 col-sm-2 col-2">
                    <label class="numero-voie" for="NumeroVoie">N° :</label>
                    <input id="NumeroVoie" type="text" name="numero_voie" value="<?= (0 == $profil->numero_voie)? '' : $profil->numero_voie  ?>"
                    class="form-control
                    mb-3">
                </div>
                <div class="col-md-3 col-sm-3 col-3">
                    <label class="type-voie" for="TypeVoie">Type :</label>
                    <input id="TypeVoie" type="text" name="type_voie" value="<?= $profil->type_voie ?>"
                    class="form-control mb-3">
                </div>
                <div class="col-md-7 col-sm-7 col-7">
                    <label class="nom-voie" for="NomVoie">Nom de la voie :</label>
                    <input id="NomVoie" type="text" name="nom_voie" value="<?= $profil->nom_voie ?>"
                    class="form-control mb-3">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-3">
                    <label class="code-postale" for="CodePostale">Code postale :</label>
                    <input id="CodePostale" type="text" name="code_postale" value="<?= (0 == $profil->code_postale )? '' : $profil->code_postale
                    ?>" class="form-control
                    mb-3">
                </div>
                <div class="col-9">
                    <label class="ville" for="Ville">Ville :</label>
                    <input id="Ville" type="text" name="ville" value="<?= $profil->ville ?>" class="form-control
                    mb-3">
                </div>
            </div>
        </div>
        <div class="col-auto mt-2">
            <input type="hidden" name="user_id" value="<?= $profil->user_id ?>">
            <button type="submit" class="btn btn-warning m-0">Modifier</button>
        </div>
    </form>
</section>