# projet-WEB
Projet Cinéflix (Frédéric, Charles)


Installer composer
https://getcomposer.org/download/
Depuis le terminal, à la racine de l'application, après avoir installé composer executer les commande:

//* PHPUnit *//

Pour les tests unitaire

composer require --dev phpunit/phpunit

//* Autoloader *//

Pour charger les classes

composer.phar dump-autoload

TODO

   - Validation des champs
        - Ajouter au script js le message adéquate dans la div .invalid-message
        - Ajouter à la div la class approprié au type d'erreur relevé
        - Ajouter la fonction required et ne pas faire la validation d'input vide avec la vérification du format
    
    - Creer une interface d'Exception
        - Trouver une solution pour gerer les messages d'erreurs, et les pages d'erreurs
        - Voir les problème d'interdépendance
        - Voir pour la journalisation de erreur
    
    
