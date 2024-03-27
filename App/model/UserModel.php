<?php

namespace Cineflix\App\Model;

class UserModel
{

    public int $id;
    public string $nom = '';
    public string $prenom;
    public string $mail;

    public function __construct()
    {
    }

}