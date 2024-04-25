<?php

namespace Cineflix\App\Model;

use Cineflix\Core\Util\Security;

class UserModel extends AbstractModel
{

    private ProfilModel $profil;

    public ?string $email = null;
    public ?string $password = null;
    public string $token;
    public int $admin = 0;
    public string $connect;
    public string $last_connect;

    public function __construct(array $data = null)
    {
        parent::__construct($data);

        if(isset($data['email'])) $this->email = $data['email'];
        if(isset($data['created'])) $this->created = $this->getDateFr($data['created']);
        if(isset($data['modified'])) $this->modified = $this->getDateFr($data['modified']);
        if(isset($data['connect'])) $this->connect = $this->getDateFr($data['connect']);
        if(isset($data['last_connect'])) $this->last_connect = $this->getDateFr($data['last_connect']);

        if(isset($data['profil'])) $this->setProfil($data['profil']);
    }

    public function setEmail(string $email): void
    {
        $this->email = Security::sanitize($email);
    }

    /**
     * @param $password
     *
     * @return void
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

    /**
     * @param array $data
     *
     * @return void
     */
    public function setProfil(array $data): void
    {
        $this->profil = new ProfilModel($data);
    }

    /**
     * @return ProfilModel
     */
    public function getProfil(): ProfilModel
    {
        return $this->profil;
    }



}