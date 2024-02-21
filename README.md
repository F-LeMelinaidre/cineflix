# projet-WEB
Projet Cinéflix (Frédéric, Charles)


Installer composer
https://getcomposer.org/download/

//* Autoloader *//

Installer l'autoloader:

Depuis le terminal, à la racine de l'application, après avoir installé composer executer la commande:

composer.phar dump-autoload

TODO
    - Revoir l'import de header.php dans index.php
        Pour la gestion des liens
        Et si le header doit être importé ou non suivant les pages (exemple: connexion, et création de compte)
    
    - Remonter l'instanciation des controller effectué dans la Class Route Methode call() ici
    
    - Creer une methode ou class pour gérer l'affichage d'erreur, et la redirection vers les pages d'erreurs
    
    - Déplacer et Renommer Les Constantes ROOT et WEBROOT ici
    
    - Essayer de ne laisser dans l'index seulement:
        ini_set()
        session_start()
        date_default_timezone_set()
        ainsi que l'appel à APP::load() biensûr sinon rien ne fonctionne
