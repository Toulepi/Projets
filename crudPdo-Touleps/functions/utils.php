<?php

/** permet de créer l'entête d'une page
 * @param $titre
 */
function template_entete($titre){
    echo <<<EOT
                <!doctype html>
        <html lang="en">
        <head>
            <title>$titre</title>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
            <!-- Font Awesomes -->
            <script src="https://kit.fontawesome.com/609c0c060b.js" crossorigin="anonymous"></script>
            
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="assets/css/bootstrap.css">
            
        </head>
        <body>
            <div class="container">
        <!-- NAVBAR -->
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <a class="navbar-brand" href="#">DAWM Asnieres</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="index.php"><i class="fas fa-home"></i>Accueil <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="liste.php">Employés</a>
                            </li>
                        </ul>
                    </div>
                </nav>
EOT;
}


/** Permet de créer le pied de page
 * @param $titre
 */
function template_pied_Page(){
    echo <<<EOT
</div>
<!-- Bootstrap JS -->
    <script src="assets/js/jQuery.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

</body>
</html>
EOT;

}

?>