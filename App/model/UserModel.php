<?php

namespace Cineflix\App\Model;

use Cineflix\Core\Util\Regex;
use Cineflix\Core\Util\Security;

class UserModel
{

    public int $id;
    public string $email;
    public string $password;


    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): void
    {
        $this->email = Security::sanitize($email);
    }

    /**
     * @param $password
     *
     * @return $this
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getPassword(): string
    {

        return $this->password;
    }
    /**
     * @param string $password
     *
     * @return $this
     */
    public function hashPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }
}