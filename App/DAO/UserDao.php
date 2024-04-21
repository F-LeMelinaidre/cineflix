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

    public function findOne(array $params, array $options = null)
    {
        $columns = (isset($options['select']))? $options['select'] : ['*'];
        $select = $this->setSelect($this->table, $columns);

        if(isset($options['hasOne'])) {
            $hasOne = $this->relations['hasOne'];

            foreach ($options['hasOne'] as $table => $opt) {

                $join[] = "JOIN $table ON {$hasOne[$table]}";

                if(isset($opt['select'])) {
                    $select .= ', '.$this->setSelect($table, $opt['select']);
                }

            }
        }

        $join = (isset($join))? implode($join) : '';

        $where = [];
        $bindValues = [];
        foreach ($params as $key => $val) {
            $where [] = "$key = :$key";
            $bindValues[] = ['col' => "$key", 'val' => $val];
        }

        $where = implode(' AND ',$where);
        $query = "SELECT $select FROM $this->table $join WHERE $where";

        $req = $this->db->prepare($query, $bindValues);
        $result = $req->fetch();

        foreach($result as $key => $val ) {

            $hasOne = array_keys($hasOne);

            foreach($hasOne as $prefix) {
                $pos = strpos($key, '_');

                if ($pos !== false) {
                    $prefix = substr($key, 0, $pos);
                    $column = substr($key, $pos + 1);

                    $result[$prefix][$column] = $result[$key];
                    unset($result[$key]);
                }

            }
        }
        return new UserModel($result);
    }
    public function create(object $user)
    {

        try {

            $this->db->beginTransaction();

            $user_data = [
                'email'     => $user->email,
                'password'  => $user->getPassword(),
            ];


            $this->db->insert($user->table,$user_data);

            $this->setLastInsertId();

            $profil = $user->getProfil();

            $profil_data = [
                'user_id' => $this->last_insert_id,
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