<?php

namespace Cineflix\App\Model;

use Cineflix\Core\Util\Security;

class UserModel extends AbstractModel
{

    private string $table = 'user';

    public int $id;
    public ?string $email = null;
    public ?string $password = null;
    public string $token;
    public int $admin = 0;
    public string $created;
    public string $modified;
    public string $connect;
    public string $last_connect;
    private ProfilModel $profil;

    public function __construct(array $data = null)
    {
        if(isset($data['id'])) $this->id = $data['id'];
        if(isset($data['email'])) $this->email = $data['email'];
        if(isset($data['created'])) $this->created = $this->setDateFr($data['created']);
        if(isset($data['modified'])) $this->modified = $this->setDateFr($data['modified']);
        if(isset($data['connect'])) $this->connect = $this->setDateFr($data['connect']);
        if(isset($data['last_connect'])) $this->last_connect = $this->setDateFr($data['last_connect']);

        if(isset($data['profil'])) $this->setProfil($data['profil']);
    }

    public function setEmail(string $email)
    {
        $this->email = Security::sanitize($email);
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