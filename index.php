<!-- Fichier de routeur -->
<?php
//constante qui définie une URL absolue
define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

require_once "controllers/livresController.php";

//On instentie le controller
$livresController = new LivresController;

//pour éviter toutes erreurs dans les url on utilise le try/catch
try {
    //Mise en place d'un système de routage
    if (empty($_GET['page'])) {
        require "views/accueil.view.php";
    } else {
        //On décompose l'URL pour gérer l'ensemble des routes sur le site
        //le filtre est une sécurité pour éviter les injections de code depuis les url
        $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));
        // echo "<pre>";
        // print_r($url);
        // echo "</pre>";


        switch ($url[0]) {   //on récupère le premier élément de l'url
            case "accueil":
                require "views/accueil.view.php";
                break;
            case "livres":
                //S'il n'y a rien après /livres dans l'url on affiche seulement les livres
                if (empty($url[1])) {
                    //on appelle la fonction qui permet d'afficher les livres présente dans le controller
                    $livresController->afficherLivres();
                } elseif ($url[1] == "afficher") {
                    $livresController->afficherLivre($url[2]);
                } elseif ($url[1] == "ajouter") {
                    $livresController->ajouterLivre(); 
                } elseif ($url[1] == "modifier") {
                    echo "modifier un livre";
                } elseif ($url[1] == "supprimer") {
                    $livresController->supprimerLivre($url[2]);
                }elseif ($url[1] == "valider") {
                    $livresController->ajouterLivreValidation();
                } else {
                    throw new Exception("Cette page n'existe pas");
                }
                break;
            default:
                throw new Exception("Cette page n'existe pas");
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
