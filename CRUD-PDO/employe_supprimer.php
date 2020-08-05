<?php
require_once "functions/app_functions.php";

// On récupère la méthode GET ou POST de la requête
//ici la méthode sera de type GET puisqu'il s'agit du click sur un lien de type <a></a>
$method = $_SERVER['REQUEST_METHOD'];

if( ($method === "GET") && empty($_GET['id']) ) {
    header("Location:employes.php");
    exit();
}

    //On vérifie que des données ont été postées
    if ( ($method === "GET") && !empty($_GET['id']) ){

        $id = htmlspecialchars( $_GET['id'] );  // protection contre les injections

        $sql = "DELETE FROM employes WHERE id = $id";

        $connexion = db_connexion();
        $req_preparee = $connexion->prepare($sql);
        $req_preparee->execute([$id]);
        #$employe = $req_preparee->fetch(PDO::FETCH_ASSOC);

    }
?>
