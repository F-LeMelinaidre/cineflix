<?php

namespace Cineflix\App\DAO;

use Cineflix\App\AppController;
use Cineflix\App\model\ProfilModel;
use Cineflix\App\Model\UserModel;
use Cineflix\Core\Database\Database;

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

            $profil_data = [
                'user_id'   => $this->last_id,
                'nom'       => $user->profil->nom,
                'prenom'    => $user->profil->prenom
            ];

            $this->db->insert('profil' ,$profil_data);

            $this->db->commit();

            $result = true;

        } catch (\PDOException $e) {
            $result = false;

            $this->db->rollback();

            echo "PDOException: " . $e->getMessage();
        }

        return $result;

    }


    public function delete()
    {
        // TODO: Implement delete() method.
    }
}