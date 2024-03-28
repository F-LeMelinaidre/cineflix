<?php

namespace Cineflix\App\Model;

class UserModel
{

    public int $id;
    public string $nom;
    public string $prenom;
    public string $mail;

    private string $password;


    public function __construct(string $nom, string $prenom, string $mail)
    {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mail = $mail;
    }

    public function setPassword(string $password) {
        $this->password = $password;
    }

    public function hashPassword(string $password) {
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }

}