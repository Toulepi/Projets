<?php
    session_start();
    require_once "assets/functions.php";
    $connexion = db_connexion();

    //Affichage
    if (!empty($_GET['all'])){
        $idUser = $_SESSION["idUser"];
        $sql =  "select * from score where (idUser = $idUser)";
        try {
            $users = $connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($users);
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    //Insertion
    if (!empty($_POST['insert'])) {

        $productString = $_SESSION["productString"];
        $product = $_SESSION["product"];
        $reponse = $_POST["reponse"];

        $correct = $_SESSION["correct"];
        $idUser = $_SESSION["idUser"];

        //unset($_SESSION['reponse']);
        $_SESSION['reponse'] = $reponse;

        print_r($_SESSION);

        if ( $reponse == $product) {

            $correct = 'OUI';
            // how to reload the productString display after a correct awswer ???

        } else {
            $correct = 'NON';
        }

        $sql = "insert into score(product, reponse, correct,idUser) values (?,?, ?,?)";
        try {
            $req_preparee = $connexion->prepare($sql);
            $req_preparee->execute([$productString, $reponse, $correct,$idUser]);
            echo "insertion réussie à game_bd";
            header("Location:game.php");
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
