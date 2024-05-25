<?php

namespace Cineflix\App\DAO;

use Cineflix\App\AppController;
use Cineflix\App\model\ProfilModel;
use Cineflix\App\Model\UserModel;
use Cineflix\Core\Database\Database;
use Cineflix\Core\Util\GenerateIdentifiant;
use Cineflix\Core\Util\MessageFlash;

class UserDao extends AbstractDAO
{

    public function create(object $user)
    {
        try {

            $this->db->beginTransaction();

            $user_data = [
                'email'     => $user->email,
                'password_hash'  => $user->password_hash,
            ];


            $this->db->insert($this->table,$user_data);

            $this->last_id = $this->db->getLastInsertId();

            $id_adherent = new GenerateIdentifiant('CFL','_');
            $id_adherent->additionalPrefix($user->profil->nom, 2)
                        ->additionalPrefix($user->profil->prenom, 2);

            $profil_data = [
                'user_id'   => $this->last_id,
                'adherent_id' => $id_adherent->getIdentifiant(),
                'nom'       => $user->profil->nom,
                'prenom'    => $user->profil->prenom
            ];

            $this->db->insert('profil' ,$profil_data);

            $this->db->commit();

            $result = true;

        } catch (\PDOException $e) {
            $result = false;

            $this->db->rollback();


            MessageFlash::create("PDOException: " . $e->getMessage(),'erreur');
        }

        return $result;

    }

    public function update($user, string $id_column = 'id'): Database
    {
        $data = [];
        $data['id'] = $user->$id_column;

        if(!is_null($user->email)) $data['email'] = $user->email;

        if(!is_null($user->password_hash)) $data['password_hash'] = $user->password_hash;
        return parent::update($data, $id_column);
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}