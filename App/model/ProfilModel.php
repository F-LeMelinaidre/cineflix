<?php

namespace Cineflix\App\Model;

class ProfilModel extends UserModel
{
    public string $table = 'profil';
    public int $user_id;

    public string $nom;
    public string $prenom;
    public string $date_naissance;
    public string $numero_voie;
    public string $type_voie ;
    public string $nom_voie;
    public int $code_postale;
    public string $ville;
    public int $point;

    public function __construct(array $data = null)
    {
        parent::__construct($data);

        if(isset($data['user_id'])) $this->user_id = $data['user_id'];
        if(isset($data['nom'])) $this->setNom($data['nom']);
        if(isset($data['prenom'])) $this->setPrenom($data['prenom']);
        if(isset($data['date_naissance'])) $this->date_naissance = $data['date_naissance'];
        if(isset($data['numero_voie'])) $this->numero_voie = $data['numero_voie'];
        if(isset($data['type_voie'])) $this->type_voie = $data['type_voie'];
        if(isset($data['nom_voie'])) $this->nom_voie = $data['nom_voie'];
        if(isset($data['code_postale'])) $this->code_postale = $data['code_postale'];
        if(isset($data['ville'])) $this->ville = $data['ville'];
        if(isset($data['point'])) $this->point = $data['point'];

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