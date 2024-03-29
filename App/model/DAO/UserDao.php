<?php

namespace Cineflix\App\Model\DAO;

use Cineflix\App\AppController;
use Cineflix\App\Model\UserModel;
use Cineflix\Core\Database\Database;

class UserDao
{
    private Database $db;

    /**
     *
     */
    public function __construct()
    {
        $this->db = AppController::$_Database;
    }

    /**
     * @param $mail
     *
     * @return mixed
     */
    public function findMailAndPwdByMail($mail)
    {
        $query ='SELECT mail, password FROM membre WHERE mail LIKE :mail';
        $bindValues[] = ['col' => 'mail', 'val' => $mail];
        $req = $this->db->prepare($query, $bindValues);
        return $req->fetch();
    }

    public function isExist($mail)
    {
        $query = 'SELECT EXISTS ( SELECT mail FROM membre WHERE mail LIKE :mail )';
        $bindValues[] = ['col' => 'mail', 'val' => $mail];
        $req = $this->db->prepare($query, $bindValues);
        return $req->count();
    }

    /**
     * @param UserModel $user
     *
     * @return bool
     */
    public function save(UserModel $user) {

        $columns[] = 'password';
        $values[]  = ':password';
        $bindValues[] = [
            'col' => 'password',
            'val' => $user->getPassword()
        ];
        foreach ($user as $key => $value) {
            $columns[] = $key;
            $values[] = ':' . $key;
            $bindValues[] = ['col' => $key, 'val' => $value];

        }

        $columns = implode(', ', $columns);
        $values = implode(', ', $values);

        $sql = "INSERT INTO membre ($columns) VALUES ($values)";

        return $this->db->insert($sql, $bindValues);

    }

}