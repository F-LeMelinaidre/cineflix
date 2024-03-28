<?php

namespace Cineflix\App\Model;

use Cineflix\Core\Util\Security;

class UserModel
{

    public int $id;
    public string $nom;
    public string $prenom;
    public string $email;
    private string $password;

    private array $validate = [
        'notEmpty'  => ['nom', 'prenom', 'email', 'password'],
        'alpha'     => ['nom', 'prenom'],
        'email'     => ['email'],
        'password'  => ['password']
    ];

    public function setNom(string $nom): self
    {
        $this->nom = Security::sanitize($nom);

        return $this;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = Security::sanitize($prenom);

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = Security::sanitize($email);

        return $this;
    }

    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

    public function hashPassword(string $password): self
    {
        $password = Security::sanitize($password);

        $this->password = password_hash($password, PASSWORD_BCRYPT);

        return $this;
    }

    public function isValid(): bool
    {
        foreach($this->validate as $rules => $items ) {

        }
        return false;
    }

    public function getErrors(): array
    {
        return [];
    }

}