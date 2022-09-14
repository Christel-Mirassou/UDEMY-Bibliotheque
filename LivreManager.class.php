<?php
// cette classe sera en charge de la liste des livres
class LivreManager{
    //tableau de livres
    private $livres;

    public function ajoutLivre($livre){
        $this->livres[] = $livre;
    }

    public function getLivres(){
        return $this->livres;
    }


}




