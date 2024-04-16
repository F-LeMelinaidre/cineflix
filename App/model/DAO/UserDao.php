<?php

namespace Cineflix\App\Model\DAO;

use Cineflix\App\AppController;
use Cineflix\App\model\ProfilModel;
use Cineflix\App\Model\UserModel;
use Cineflix\Core\Database\Database;

class UserDao
{
    private Database $db;
    private $model = UserModel::class;
    /**
     *
     */
    public function __construct()
    {
        $this->db = AppController::$_Database;
    }

    public function findByMail($email)
    {
        $this->model = UserModel::class;
        $query = "SELECT profil.nom, profil.prenom, membre.email FROM membre JOIN profil ON membre.id = profil.membre_id WHERE email LIKE :email";

        $bindValues[] = ['col' => 'email', 'val' => $email];
        $req = $this->db->prepare($query, $bindValues);

        return $req->fetch($this->model);
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

    /**
     * @return void
     */
    public function findUserWithProfilByEmail($email)
    {
        $query = 'SELECT membre.id, membre.email, profil.membre_id, profil.nom, profil.prenom, profil.date_naissance, profil.numero_voie, profil.type_voie, profil.nom_voie, profil.code_postale, profil.ville 
                   FROM membre AS membre
                   JOIN profil ON membre.id = profil.membre_id
                   WHERE email = :email';

        $bindValues[] = ['col' => 'email', 'val' => $email];

        $req = $this->db->prepare($query, $bindValues);

        return $req->fetch(ProfilModel::class);

    }

    public function create()
    {

    }
    /**
     * @param UserModel $user
     *
     * @return bool
     */
    public function save(UserModel $user) {

        //$columns[] = 'password';
        //$values[]  = ':password';
        //$bindValues[] = [
        //    'col' => 'password',
        //    'val' => $user->getPassword()
        //];
        foreach ($user as $key => $value) {
            $columns[] = $key;
            $values[] = ':' . $key;
            $bindValues[] = ['col' => $key, 'val' => $value];

        }

        $columns = implode(', ', $columns);
        $values = implode(', ', $values);

        $sql = "INSERT INTO membre ($columns) VALUES ($values)";

        $res = $this->db->insert($sql, $bindValues);

        echo $this->db->getLastInsertId();

        die();

        return $this->db->insert($sql, $bindValues);

    }

}