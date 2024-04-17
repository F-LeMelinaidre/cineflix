<?php

namespace Cineflix\App\DAO;

use Cineflix\App\AppController;
use Cineflix\App\model\ProfilModel;
use Cineflix\App\Model\UserModel;
use Cineflix\Core\Database\Database;

class UserDao extends AbstractDAO
{
    private int $lastInsertId;

    public function create(object $user)
    {

        try {

            $this->db->beginTransaction();

            $user_data = [
                'email'     => $user->email,
                'password'  => $user->getPassword()
            ];


            $this->db->insert($user->table,$user_data);

            $profil = $user->getProfil();

            $profil_data = [
                'membre_id' => $this->db->getLastInsertId(),
                'nom'       => $profil->nom,
                'prenom'    => $profil->prenom
            ];

            $this->db->insert($profil->table ,$profil_data);

            $this->db->commit();

            $result = true;

        } catch (\PDOException $e) {
            $result = false;

            $this->db->rollback();

            echo "PDOException: " . $e->getMessage();
        }

        return $result;

    }

    public function getLastInsertId()
    {
        return $this->lastInsertId;
    }
    public function findByMail($email)
    {
        $query = "SELECT p.nom AS nom, p.prenom AS prenom, m.email AS email FROM membre AS m JOIN profil AS p ON m.id = p.membre_id WHERE email LIKE :email";

        $bindValues[] = ['col' => 'email', 'val' => $email];
        $req = $this->db->prepare($query, $bindValues);

        return $req->fetch();
    }
    /**
     * @param $mail
     *
     * @return null
     */
    public function isExist($email)
    {
        $query = 'SELECT EXISTS ( SELECT email FROM membre WHERE email LIKE :email )';
        $bindValues[] = ['col' => 'email', 'val' => $email];
        $req = $this->db->prepare($query, $bindValues);
        return $req->count();
    }

    public function read()
    {
        // TODO: Implement read() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}