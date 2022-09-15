<?php
require_once "models/livreManager.class.php";

class LivresController
{
    private $livreManager;

    public function __construct()
    {
        //Le constructeur instentie le livreManager
        //pour remplir l'attribut $livreManager on met le $this-> devant
        $this->livreManager = new LivreManager;
        //chargement de tous les livres présents en Bdd au moment du constructeur
        $this->livreManager->chargementLivres();
    }

    //Fonction qui permet de gérer la route pour afficher les livres
    public function afficherLivres()
    {
        //on récupère tous les livres en Bdd que l'on met dans une variable $livres
        $livres = $this->livreManager->getLivres();
        //$livres est maintenant accessible dans la vue
        require "views/livres.view.php";
    }

    //Fonction qui peremt d'afficher un livre trouvé grâce à son id 
    public function afficherLivre($id){
        //pour cela on doit utiliser une fonction définie dans le livreManager car concerne les datas
        $livre = $this->livreManager->getLivreById($id);
        //On peut appeler la vue pour afficher le livre
        require "views/afficherLivre.view.php";
    }
}
