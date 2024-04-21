<?php

namespace Cineflix\App\Model;

class UserModel
{

    public string $table = 'user';

    public int $id;
    public string $email;

    public string $token;
    public string $password;
    public int $admin;
    public ProfilModel $profil;

    public function __construct(array $data = null)
    {
        if(isset($data['id'])) $this->id = $data['id'];
        if(isset($data['email'])) $this->email = $data['email'];
        if(isset($data['profil'])) $this->setProfil($data['profil']);
    }

    /**
     * @param $password
     *
     * @return $this
     */
    public function setPassword($password): void
    {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setProfil(array $data)
    {
        $this->profil = new ProfilModel($data);
    }
    public function getProfil()
    {
        return $this->profil;
    }

}