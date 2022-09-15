<?php
//Pour avoir accès au fichier contenant la classe Model
require_once "Model.class.php";
require_once "Livre.class.php";

// cette classe sera en charge de la liste des livres
// elle hérite de la classe Model
class LivreManager extends Model{
    //tableau de livres
    private $livres;

    public function ajoutLivre($livre){
        $this->livres[] = $livre;
    }

    public function getLivres(){
        return $this->livres;
    }

    //Fonction qui permet de récupérer tous les livres présents en BDD
    public function chargementLivres(){
        //requète à la Bdd
        $req = $this->getBdd()->prepare("SELECT * FROM livres");
        $req->execute();
        $mesLivres = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor(); //termine la requète

        //on peut maintenant créer des objets de type Livre depuis la BDD et de les ajouter à la liste
        foreach ($mesLivres as $livre) {
            $l = new Livre($livre['id'], $livre['titre'], $livre['nbPages'], $livre['image']);
            $this->ajoutLivre($l);
        }
    }

}




