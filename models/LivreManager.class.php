<?php
//Pour avoir accès au fichier contenant la classe Model
require_once "Model.class.php";
require_once "Livre.class.php";

// cette classe sera en charge de la liste des livres
// elle hérite de la classe Model
class LivreManager extends Model
{
    //tableau de livres
    private $livres;

    public function ajoutLivre($livre)
    {
        $this->livres[] = $livre;
    }

    public function getLivres()
    {
        return $this->livres;
    }

    //Fonction qui permet de récupérer tous les livres présents en BDD
    public function chargementLivres()
    {
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

    //Fonction qui permet de cherche un livre en BDD grâce à son id
    public function getLivreById($id)
    {
        for ($i = 0; $i < count($this->livres); $i++) {
            if ($this->livres[$i]->getId() === $id) {
                return $this->livres[$i];
            }
        }
    }

    //Fonction qui permet d'ajouter le livre en BDD
    public function ajouterLivreBdd($titre, $nbPages, $image)
    {
        //on défini la requète pour insérer en BDD
        $req = "INSERT INTO livres (titre, nbPages, image) VALUES (:titre, :nbPages, :image)";

        //on prépare la requète
        $stmt = $this->getBdd()->prepare($req);

        // on utilise la fonction bindValue pour sécuriser les données
        $stmt->bindValue(':titre', $titre, PDO::PARAM_STR);
        $stmt->bindValue(':nbPages', $nbPages, PDO::PARAM_INT);
        $stmt->bindValue(':image', $image, PDO::PARAM_STR);

        //on exécute la requète 
        $resultat = $stmt->execute();

        //on referme la connexion
        $stmt->closeCursor();

        //on ajoute le livre au tableau de livres 
        //On vérifie que le livre a bien été ajouté en BDD
        if ($resultat > 0) {
            //on récupère l'id du livre ajouté en BDD par le dernier id inséré
            $livre = new Livre($this->getBdd()->lastInsertId(), $titre, $nbPages, $image);
            //on ajoute le livre au tableau de livres
            $this->ajoutLivre($livre);
        }
    }

    //Fonction qui permet de supprimer un livre en BDD
    public function supprimerLivreBdd($id){
        //on définie la requète
        $req = "DELETE FROM livres WHERE id = :id";

        //on prépare la requète
        $stmt = $this->getBdd()->prepare($req);

        //on sécurise les données
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        //on exécute la requète
        $resultat = $stmt->execute();

        //on referme la connexion
        $stmt->closeCursor();

        //on supprime le livre du tableau de livres
        //on vérifie que le livre a bien été supprimé en BDD
        if ($resultat > 0) {
            $livre = $this->getLivreById($id);
            unset($livre);
        }
    }

    //Fonction qui permet de modifier un livre en BDD
    public function modifierLivreBdd($id, $titre, $nbPages, $image)
    {
        //on définie la requète
        $req = "UPDATE livres SET titre = :titre, nbPages = :nbPages, image = :image WHERE id = :id";

        //on prépare la requète
        $stmt = $this->getBdd()->prepare($req);

        //on sécurise les données
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':titre', $titre, PDO::PARAM_STR);
        $stmt->bindValue(':nbPages', $nbPages, PDO::PARAM_INT);
        $stmt->bindValue(':image', $image, PDO::PARAM_STR);

        //on exécute la requète
        $resultat = $stmt->execute();

        //on referme la connexion
        $stmt->closeCursor();

        //on modifie le livre du tableau de livres
        //on vérifie que le livre a bien été modifié en BDD
        if ($resultat > 0) {
            $this->getLivreById($id)->setTitre($titre);
            $this->getLivreById($id)->setNbPages($nbPages);
            $this->getLivreById($id)->setImage($image);
        }
    }
}
