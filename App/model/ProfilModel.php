<?php

namespace Cineflix\App\model;

use Cineflix\Core\Util\Security;

class ProfilModel extends UserModel
{
    public int $membre_id;

    public string $nom;
    public string $prenom;
    public string $date_naissance;
    public string $numero_voie;
    public string $type_voie;
    public string $nom_voie;
    public int $code_postale;
    public string $ville;

    /**
     * @param string $nom
     *
     * @return $this
     */
    public function setNom(string $nom)
    {
        $this->nom = ucfirst($nom);
    }

    /**
     * @param string $prenom
     *
     * @return $this
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = ucfirst($prenom);
    }

    public function getAddress(): string
    {
        return $this->numero_voie. ' ' .$this->type_voie. ' ' .$this->nom_voie;
    }
}