<?php

namespace Cineflix\App\Model;

use Cineflix\Core\Util\Regex;
use Cineflix\Core\Util\Security;

class UserModel
{

    public int $id;
    public string $nom;
    public string $prenom;
    public string $email;

    public array $errors;
    private string $password;


    /**
     * @param string $nom
     *
     * @return $this
     */
    public function setNom(string $nom): self
    {
        $this->nom = Security::sanitize($nom);

        return $this;
    }

    /**
     * @param string $prenom
     *
     * @return $this
     */
    public function setPrenom(string $prenom): self
    {
        $this->prenom = Security::sanitize($prenom);

        return $this;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = Security::sanitize($email);

        return $this;
    }

    /**
     * @param $password
     *
     * @return $this
     */
    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function hashPassword(string $password): self
    {
        $password = Security::sanitize($password);

        $this->password = password_hash($password, PASSWORD_BCRYPT);

        return $this;
    }

}