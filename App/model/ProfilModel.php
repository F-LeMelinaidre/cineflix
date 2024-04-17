<?php

namespace Cineflix\App\Model;

class ProfilModel extends UserModel
{
    public string $table = 'profil';
    public int $membre_id;

    public string $nom = '';
    public string $prenom = '';
    public string $date_naissance = '';
    public string $numero_voie = '';
    public string $type_voie = '';
    public string $nom_voie = '';
    public int $code_postale = 0;
    public string $ville = '';

    /**
     * @param int $id
     *
     * @return void
     */
    public function setUserId(int $id): void
    {
        $this->membre_id = $id;
    }

    /**
     * @param string $nom
     *
     * @return $this
     */
    public function setNom(string $nom): void
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