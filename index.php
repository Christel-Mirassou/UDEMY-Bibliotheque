<!-- Fichier de routeur -->
<?php
require_once "controllers/livresController.php";

//On instentie le controller
$livresController = new LivresController;

//Mise en place d'un système de routage 
if (empty($_GET['page'])) {
    require "views/accueil.view.php";
}else{
    switch($_GET['page']){
        case "accueil":
            require "views/accueil.view.php";
            break;
        case "livres":
            //on appelle la fonction qui permet d'afficher les livres présente dans le controller
            $livresController->afficherLivres();
            break;
    }
}
