<?php

namespace Cineflix\App\Model;

class UserModel
{

    public string $table = 'membre';

    public int $id;
    public string $email = '';
    private string $password;
    private ProfilModel $profil;

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

    public function setProfil($nom, $prenom)
    {
        $this->profil = new ProfilModel();
        $this->profil->setNom($nom);
        $this->profil->setPrenom($prenom);
    }
    public function getProfil()
    {
        return $this->profil;
    }

}