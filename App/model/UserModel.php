<?php

namespace Cineflix\App\Model;

class UserModel
{

    public int $id;
    public string $nom = '';
    public string $prenom;
    public string $mail;
    private string $password;

    public function __construct($data)
    {
        $this->nom = $data['nom'];
        $this->prenom = $data['prenom'];
        $this->mail = $data['mail'];
    }



}
