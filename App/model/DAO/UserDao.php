<?php

namespace Cineflix\App\Model\DAO;

use Cineflix\App\AppController;
use Cineflix\App\Model\UserModel;
use Cineflix\Core\Database\Database;

class UserDao
{
    private Database $db;

    public function __construct()
    {
        $this->db = AppController::$_Database;
    }

    public function isExist($mail)
    {
        $query = 'SELECT EXISTS ( SELECT mail FROM membre WHERE mail LIKE :mail )';
        $bindValue[] = ['col' => 'mail', 'val' => $mail];
        $req = $this->db->prepare($query, $bindValue);
        return $req->count();
    }

    public function save(UserModel $user) {

    }

}