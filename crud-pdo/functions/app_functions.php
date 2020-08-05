<?php
/**Permet  de construire l'entête d'une page HTML5
 * @param $titre_page
 */
function build_header($titre_page)
{
    echo <<<TAG
        <!doctype html>
        <html lang="en">
        <head>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="assets/css/bootstrap.css">
            <!--Notre propre CSS -->
            <link rel="stylesheet" href="assets/css/app.css">
        
            <title>$titre_page</title>
        </head>
        <body>
        
            <div class="container">
                <!-- Debut NAVBAR-->
                <nav class="navbar navbar-expand-md bg-primary navbar-dark">
                    <!-- Brand -->
                    <a class="navbar-brand" href="#">DWWM-ASNIERES</a>
        
                    <!-- Toggler/collapsibe Button -->
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
        
                    <!-- Navbar links -->
                    <div class="collapse navbar-collapse" id="collapsibleNavbar">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="employes.php">Employés</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">se Deconnecter</a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- Fin NAVBAR-->
TAG;
}

/**Permet de construire le pied de page
 *
 */
function build_footer()
{
    echo<<<EOT
     <!-- Début pied de page -->
     
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script defer src="assets/js/jQuery.js"></script>
        <script defer src="assets/js/bootstrap.bundle.min.js"></script>
        <script defer src="assets/js/bootstrap.min.js"></script>
    </body>
    </html>
    
    <!-- Fin pied de page -->
EOT;

}

/** Permet de réaliser la connexion à une base de données
 * @return PDO
 */
function db_connexion(){
    $database = "crud_pdo_db";
    $user = "root";
    $pass = "";

    //URL de la BDD
    $url = "mysql:host=localhost;dbname=$database;charset=utf8";

    try {
        //on essaie d'établir une connexion à la BDD
        $connexion = new PDO($url,$user,$pass);  //$connexion is a PDO instance representing a connection to a database

        //On retourne une instance de PDO
        return $connexion;

        // En cas d'erreur, prend en charge la gestion des erreurs
        //$connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    } catch (Exception $e){
        // On lève une exception
        exit($e->getMessage());  //appel de la méthode 'getMessage' de la classe "Exception" pour afficher un message d'erreur
    }

}

?>