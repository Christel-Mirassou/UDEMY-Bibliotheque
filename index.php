<!-- Fichier de routeur -->
<?php

//Mise en place d'un système de routage 
if (empty($_GET['page'])) {
    require "views/accueil.view.php";
}else{
    switch($_GET['page']){
        case "accueil":
            require "views/accueil.view.php";
            break;
        case "livres":
            require "views/livres.view.php";
            break;
    }
}
