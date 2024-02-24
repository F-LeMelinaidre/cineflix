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

    - Revoir l'import de header.php dans index.php
        Pour la gestion des liens
        Et si le header doit être importé ou non suivant les pages (exemple: connexion, et création de compte)
    
    - Creer une interface d'Exception
        - Trouver une solution pour gerer les messages d'erreurs, et les pages d'erreurs
        - Voir les problème d'interdépendance
        - Voir pour la journalisation de erreur
    
    - Renommer Les Constantes ROOT et WEBROOT

    - Deplacer le dossier Element dans View
