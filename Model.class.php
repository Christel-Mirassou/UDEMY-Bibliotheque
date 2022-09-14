<?php

//Classe abstraite car ne doit JAMAIS être instentiable directement
abstract class Model{
    //Cet attribut est static de façon à ce que toutes les classes qui vont hériter de la classe Model puissent y avoir accès
    private static $pdo;

    //Fonction qui permet la connexion à la base de données et qui n'est appelée seulement qu'à la connexion
    private static function setBdd(){
        self::$pdo = new PDO("mysql:host=localhost;dbname=udemy_bibliotheque;charset=utf8", 'root', '');
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    //Fonction qui déclenche la connexion à la BDD et qui donc appelle la fonction qui permet la connexion
    //Fonction CRUCIALE !!!
    //Fonction accessible uniquement par les classes filles 
    protected function getBdd(){
        if (self::$pdo === null) {
            //si l'attribut est null alors on créé la connexion
            self::setBdd();
        }
        return self::$pdo;
    }


}












