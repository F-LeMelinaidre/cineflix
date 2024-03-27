<?php

namespace Cineflix\App\Model;

class AccountModel
{

    const REGEX_NOM_PRENOM = '/[a-zA-Zàâçéèêëïîôùûüÿ\-\s]+/';

    // Validation Email en utilisant la norme RFC2822
    const REGEX_MAIL = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(
    ([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';

    const ERRORS_MSG = [
        'empty'     => 'Champ obligatoire !',
        'carateres' => 'Seul les majuscules, minuscules et caratères accentués !',
        'mail'      => 'Format invalide (norme RFC2822) !'
    ];

    public string $nom = '';
    public string $prenom;
    public string $mail;
    public string $password;

    private array $errors;

    public function __construct()
    {

    }

    public function setLastName(string $nom)
    {
        $nom = $this->clean($nom);
        if(empty($nom)) {
            $this->errors['nom'] = self::ERRORS_MSG['empty'];
        } elseif(preg_match(self::REGEX_NOM_PRENOM, $nom)) {
            $this->errors['nom'] = self::ERRORS_MSG['carateres'];
        } else {
            $this->nom = $nom;
        }

    }

    public function setFirstName(string $prenom)
    {
        $prenom = $this->clean($prenom);
        if(empty($prenom)) {
            $this->errors['prenom'] = self::ERRORS_MSG['empty'];
        } elseif(preg_match(self::REGEX_NOM_PRENOM, $prenom)) {
            $this->errors['prenom'] = self::ERRORS_MSG['carateres'];
        } else {
            $this->prenom = $prenom;
        }
    }

    public function setMail(string $mail)
    {
        $mail = $this->clean($mail);
        if(empty($mail)) {
            $this->errors['mail'] = self::ERRORS_MSG['empty'];
        } elseif(preg_match(self::REGEX_MAIL, $mail)) {
            $this->errors['mail'] = self::ERRORS_MSG['mail'];
        } else {
            $this->mail = $mail;
        }
    }

    public function setPassword(string $password, string $password_confirme)
    {
        $this->password = $this->clean($password);
    }

    private function clean($value): string {
        // supprime les espaces en debut et fin de chaine
        $value = trim($value);
        // remplace les espaces blancs multiples par un unique espace blanc pour les noms et prénoms
        $value = preg_replace('/\s+/', ' ', $value);
        // Convertit les caractères spéciaux en entités HTML
        return htmlspecialchars(trim($value));
    }

}