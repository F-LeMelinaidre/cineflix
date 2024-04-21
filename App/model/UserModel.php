<?php

namespace Cineflix\App\Model;

class UserModel
{

    public string $table = 'user';

    public int $id;
    public string $email;
    public string $password;
    public string $token;
    public int $admin;
    public string $created;
    public string $modified;
    public string $connect;
    public string $last_connect;
    private ProfilModel $profil;

    public function __construct(array $data = null)
    {
        if(isset($data['id'])) $this->id = $data['id'];
        if(isset($data['email'])) $this->email = $data['email'];
        if(isset($data['created'])) $this->created = $data['created'];
        if(isset($data['modified'])) $this->modified = $data['modified'];
        if(isset($data['connect'])) $this->connect = $data['connect'];
        if(isset($data['last_connect'])) $this->last_connect = $data['last_connect'];

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