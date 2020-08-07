<?php

    /**
     * Permet de se connecter à la base de données de game_db
     * @return PDO une instance de la classe PDO, sinon leve une execption
     */
    function db_connexion()
    {
        //Les paprametres de connexion à la base de données
        $database = "game_db";
        $user = "root";
        $pass = "";
        //L'URL de la BDD
        $url = "mysql:host=127.0.0.1;dbname=$database;charset=utf8";

        try {
            //Connexion à la base de données
            $connexion = new PDO($url, $user, $pass);
            //Passe le parametre local des dates à notre connexion
            $connexion->exec("set lc_time_names='fr_FR'");
            //générer des exceptions en cas d'erreur
            $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //On retourne une instance de la connexion
            return $connexion;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

?>
