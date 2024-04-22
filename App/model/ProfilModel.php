<?php

namespace Cineflix\App\Model;

use Cineflix\Core\Util\Regex;
use Cineflix\Core\Util\Security;

class ProfilModel extends AbstractModel
{
    private string $table = 'profil';
    private array $rules = [
        'nom'            => ['alpha', 'require'],
        'prenom'         => ['alpha', 'require'],
        'date_naissance' => ['date', 'require'],
        'numero_voie'    => ['alphaNumeric', 'require'],
        'type_voie'      => ['alpha', 'require'],
        'nom_voie'       => ['alphaNumeric', 'require'],
        'code_postale'   => ['numeric', 'require'],
        'ville'          => ['alpha', 'require']
    ];

    public int $user_id;

    public ?string $nom = null;
    public ?string $prenom = null;
    public ?string $date_naissance = null;
    public ?string $numero_voie = null;
    public ?string $type_voie = null;
    public ?string $nom_voie = null;
    public ?int $code_postale = null;
    public ?string $ville = null;
    public ?int $point = null;
    public ?string $modified = null;
    public ?string $created = null;

    public UserModel $user;

    public function __construct(array $data = null)
    {
        if(isset($data['user_id']))
            $this->user_id = $data['user_id'];

        if(isset($data['nom']))
            $this->setNom($data['nom']);

        if(isset($data['prenom']))
            $this->setPrenom($data['prenom']);

        if(isset($data['date_naissance']))
            $this->date_naissance = $this->setDateFr($data['date_naissance']);

        if(isset($data['numero_voie']))
            $this->numero_voie = $data['numero_voie'];

        if(isset($data['type_voie']))
            $this->type_voie = $data['type_voie'];

        if(isset($data['nom_voie']))
            $this->nom_voie = $data['nom_voie'];

        if(isset($data['code_postale']))
            $this->code_postale = $data['code_postale'];

        if(isset($data['ville']))
            $this->ville = $data['ville'];

        if(isset($data['point']))
            $this->point = $data['point'];

        if(isset($data['created']))
            $this->created = $this->setDateFr($data['created']);

        if(isset($data['modified']))
            $this->modified = $this->setDateFr($data['modified']);

        if(isset($data['user']))
            $this->user = new UserModel($data['user']);

    }

    /**
     * @param string $nom
     *
     * @return $this
     */
    public function setNom(string $nom): void
    {
        $this->nom = ucfirst(Security::sanitize($nom));
    }

    /**
     * @param string $prenom
     *
     * @return $this
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = ucfirst(Security::sanitize($prenom));
    }

    public function setDateNaissance(string $date): void
    {
        $this->date_naissance = Security::sanitize($date);
    }

    public function setNumeroVoie(string $n_voie): void
    {
        $this->numero_voie = Security::sanitize($n_voie);
    }

    public function setTypeVoie(string $type): void
    {
        $this->type_voie = Security::sanitize($type);
    }

    public function setNomVoie(string $nom_voie): void
    {
        $this->nom_voie = Security::sanitize($nom_voie);
    }

    public function setCodePostale(int $cp): void
    {
        $this->code_postale = Security::sanitize($cp);
    }

    public function setVille(string $ville): void
    {
        $this->ville = Security::sanitize($ville);
    }

    public function getAddress(): string
    {
        return $this->numero_voie. ' ' .$this->type_voie. ' ' .$this->nom_voie;
    }

    public function isValid(): bool
    {
        foreach($this as $k => $v) {
            if(array_key_exists($k, $this->rules) && isset($this->$k)) {
                echo $k. ' - ' .$v. '<br>';
                $this->validate($this->rules[$k], $v);
            }
        }
        return false;
    }

    private function validate($rules, $value)
    {
        foreach ($rules as $rule)
        {
            if($rule === 'require' && empty($value)) {
                echo 'vide'.$rule.'<br>';
            }elseif(!empty($value) && $rule !== 'require' && !Regex::getPattern($rule,$value)){

                echo 'non vide'.$rule.'<br>';
            }
        }
    }

}