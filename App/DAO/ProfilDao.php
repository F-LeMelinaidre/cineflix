<?php

    namespace Cineflix\App\DAO;

    use Cineflix\App\Model\ProfilModel;
    use Cineflix\Core\Database\Database;

    class ProfilDao extends AbstractDAO
    {

        public function update($profil, string $id_column = 'user_id'): Database
        {
            $data = [];

            $data['id'] = $profil->$id_column;

            if(!is_null($profil->nom)) $data['nom'] = $profil->nom;

            if(!is_null($profil->prenom)) $data['prenom'] = $profil->prenom;

            if(!is_null($profil->date_naissance)) $data['date_naissance'] = $profil->date_naissance;

            if(!is_null($profil->numero_voie)) $data['numero_voie'] = $profil->numero_voie;

            if(!is_null($profil->type_voie)) $data['type_voie'] = $profil->type_voie;

            if(!is_null($profil->nom_voie)) $data['nom_voie'] = $profil->nom_voie;

            if(!is_null($profil->code_postale)) $data['code_postale'] = $profil->code_postale;

            if(!is_null($profil->ville)) $data['ville'] = $profil->ville;

            if(!is_null($profil->point)) $data['point'] = $profil->point;

            return parent::update($data, $id_column);
        }
    }