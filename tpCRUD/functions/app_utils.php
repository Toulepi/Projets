<?php

/**
 * Permet de se connecter à la base de données de l'exercice
 * @return PDO une instance de la classe PDO, sinon leve une execption
 */
function db_connexion()
{
    //Les paprametres de connexion à la base de données
    $database = "dwwm_db";
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

/**
 * Permet de creer l'en-tete de notre site
 * @param $titre
 */
function Entete_page($titre)
{
    echo <<<EOT
        <!doctype html>
        <html lang="fr">
        <head>
            <title>$titre</title>
            <meta name="description" content="Mini projet sur les opérations de CRUD"/>
            <meta name="author" content="Toulepi!"/>
        
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
        
            <!-- FontAwesome KIT -->
            <script src="https://kit.fontawesome.com/609c0c060b.js" crossorigin="anonymous"></script>
        
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="assets/css/bootstrap.css"/>
            <link rel="stylesheet" href="assets/css/style.css>
        </head>
        <body>
            
        <div class="container">
            <div class="col-md-12">
                <!--BAR DE NAVIGATION-->
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="index.php">
                        <img class="logo" src="assets/img/j4l_logo.svg" width="50em" height="50em" alt="Logo j4l">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="nav-link" href="#">Blog</a>
                    <a class="nav-link" href="index.php">Accueil</a>
                    <div class="collapse navbar-collapse" id="">
                        <ul class="navbar-nav ml-md-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="login.php">Login </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Register</a>
                            </li>
                        </ul>
                    </div>
                </nav>
    EOT;
}

/**
 * Permet de creer le pied de page
 */
function Pied_page()
{
    echo <<<EOT
            </div>    
          </div>
            <footer id="footer" class="container fixed-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-lg-8 mx-auto">
                            <p class="copyright text-center">Copyright &copy; j4l 2020 | pour dwwm-asnieres</p>
                            </div>
                    </div>
                </div>
            </footer>
    
            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="assets/js/jquery.js"></script>
            <script src="assets/js/bootstrap.bundle.min.js"></script>
            <script src="assets/js/bootstrap.min.js"></script>
            </body>
            </html>
    EOT;
}
