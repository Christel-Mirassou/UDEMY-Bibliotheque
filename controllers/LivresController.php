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

        //on vide le contenu de la variable alert sans quoi le message s'affichera continuellment
        unset($_SESSION['alert']);
    }

    //Fonction qui peremt d'afficher un livre trouvé grâce à son id 
    public function afficherLivre($id)
    {
        //pour cela on doit utiliser une fonction définie dans le livreManager car concerne les datas
        $livre = $this->livreManager->getLivreById($id);
        //On peut appeler la vue pour afficher le livre
        require "views/afficherLivre.view.php";
    }

    //Fonction qui permet d'ajouter un livre 
    public function ajouterLivre()
    {
        //Il suffit d'appeler la vue pour afficher le formulaire d'ajout
        require "views/ajouterLivre.view.php";
    }

    //Fonction qui permet de valider l'ajout d'un livre depuis le formulaire
    public function ajouterLivreValidation()
    {
        //on récupère les informations de l'image 
        $file = $_FILES['image'];
        $repertoire = "public/images/";
        $nomImageAjoutee = $this->ajouterImage($file, $repertoire);

        //on ajoute le livre en BDD
        $this->livreManager->ajouterLivreBdd($_POST['titre'], $_POST['nbPages'], $nomImageAjoutee);

        //on enregistre une information en session 
        $_SESSION['alert'] = [
            "type" => "success",   //définie la couleur du message affiché
            "message" => "Le livre a bien été ajouté"
        ];

        //on redirige vers la page des livres
        header("Location: " . URL . "livres");
    }

    //Fonction qui traite les informations d'une image pour pouvoir l'enregistrer en BDD. 
    //On passe ne paramètres le fichier image et le dossier qui doit recevoir cette image
    private function ajouterImage($file, $dir)
    {
        //on vérifie si une image a été renseignée dans le formulaire
        if (!isset($file['name']) || empty($file['name'])) {
            //si non on affiche un message d'erreur
            throw new Exception("Vous devez choisir une image");
        }

        //ensuite on vérifie si le répertoire qui doit recevoir l'image existe ou non
        if (!file_exists($dir)) {
            //s'il n'existe pas alors il va le créer avec les droits 0777: accessilble à tous
            mkdir($dir, 0777);
        }

        //on récupère l'extension de l'image
        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        //on ajoute un chiffre aléatoire pour éviter les doublons
        $random = rand(0, 99999);
        //on crée le nom de l'image
        $target_file = $dir . $random . "_" . $file['name'];

        //différents tests pour vérifier que tout marche bien
        //on vérifie que l'image ne est une
        if (!getimagesize($file['tmp_name'])) {
            throw new Exception("Le fichier n'est pas une image");
        }
        //on vérifie que l'extension de l'image est bonne
        if ($extension != "jpg" && $extension != "png" && $extension != "jpeg" && $extension != "gif") {
            throw new Exception("Seules les images au format jpg, jpeg, png et gif sont autorisées");
        }
        //on vérifie que le fichier n'existe pas déjà
        if (file_exists($target_file)) {
            throw new Exception("Le fichier existe déjà");
        }
        //on vérifie que l'image n'est pas trop lourde
        if ($file['size'] > 500000) {
            throw new Exception("Le fichier est trop lourd");
        }
        //on vérifie que le fichier a bien été uploadé
        if (!move_uploaded_file($file['tmp_name'], $target_file)) {
            throw new Exception("L'image n'a pas été uploadée");
        } else {
            //si tout est ok alors on peut ajouter l'image en BDD
            return ($random . "_" . $file['name']);
        }
    }

    //Fonction qui permet de supprimer un livre
    public function supprimerLivre($id)
    {
        //on récupère l'image du livre grâce à son id 
        $nomImage = $this->livreManager->getLivreById($id)->getImage();

        //on supprime l'image dans le répertoire
        unlink("public/images/" . $nomImage);

        //on supprime l'image en Bdd
        $this->livreManager->supprimerLivreBdd($id);

        //on enregistre une information en session 
        $_SESSION['alert'] = [
            "type" => "success",   //définie la couleur du message affiché
            "message" => "Le livre a bien été supprimé"
        ];

        //on redirige vers la page des livres
        header("Location: " . URL . "livres");
    }

    //Fonction qui permet de modifier un livre
    public function modifierLivre($id)
    {
        //on commence par récupérer toutes les informations livre à modifier grâce à son id
        $livre = $this->livreManager->getLivreById($id);
        require "views/modifierLivre.view.php";
    }

    //Fonction qui permet de valider la modification d'un livre
    public function modifierLivreValidation()
    {
        //on récupère l'image 
        $imageActuelle = $this->livreManager->getLivreById($_POST['id'])->getImage();

        //on vérifie que l'utilisateur à bien choisi une image
        $file = $_FILES['image'];
        if ($file['size'] > 0) {
            //si oui alors on supprime l'ancienne image
            unlink("public/images/" . $imageActuelle);
            //on ajoute la nouvelle image
            $repertoire = "public/images/";
            $nomImageAjoutee = $this->ajouterImage($file, $repertoire);
        } else {
            //si non alors on garde l'ancienne image
            $nomImageAjoutee = $imageActuelle;
        }

        //on modifie le livre en BDD
        $this->livreManager->modifierLivreBdd($_POST['id'], $_POST['titre'], $_POST['nbPages'], $nomImageAjoutee);

        //on enregistre une information en session 
        $_SESSION['alert'] = [
            "type" => "success",   //définie la couleur du message affiché
            "message" => "Le livre a bien été modifié"
        ];

        //on redirige vers la page des livres
        header("Location: " . URL . "livres");
    }
}
