<?php

namespace Cineflix\App\Model;

class UserModel
{

    public int $id;
    public string $nom;
    public string $prenom;
    public string $mail;
    public int $point;
    private string $password;

    public function __construct()
    {

    }

    public function setPassword()
    {
        //TODO setter du password hashé
    }

    public function getPassword()
    {
        //TODO getter password
    }

}