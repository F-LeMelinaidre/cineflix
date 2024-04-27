<?php

namespace Cineflix\App\DAO;

use Cineflix\App\AppController;
use Cineflix\App\model\ProfilModel;
use Cineflix\App\Model\UserModel;
use Cineflix\Core\Database\Database;

class UserDao extends AbstractDAO
{

    /**
     * nom de la table jointe | cle de la table courante , cle de la table jointe
     * @var array|array[]
     */
    protected array $relations = [
        'hasOne' => [
            'profil' => 'user.id = profil.user_id'
            ]
    ];


    public function create(object $user)
    {

        try {

            $this->db->beginTransaction();

            $user_data = [
                'email'     => $user->email,
                'password'  => $user->getPassword(),
            ];


            $this->db->insert($this->table,$user_data);

            $this->setLastInsertId();

            $profil = $user->getProfil();

            $profil_data = [
                'user_id' => $this->last_insert_id,
                'nom'       => $profil->nom,
                'prenom'    => $profil->prenom
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

    /**
     * @param $mail
     *
     * @return null
     */
    public function isExist($email)
    {
        $query = 'SELECT EXISTS ( SELECT email FROM user WHERE email LIKE :email )';
        $bindValues[] = ['col' => 'email', 'val' => $email];
        $req = $this->db->prepare($query, $bindValues);
        return $req->count();
    }


    public function delete()
    {
        // TODO: Implement delete() method.
    }
}