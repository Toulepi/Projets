<?php
    require_once "assets/functions.php";

// On récupère la méthode GET ou POST de la requête
$method = $_SERVER['REQUEST_METHOD'];

//On vérifie que des données ont été postées
if ( ($method == "POST") && !empty($method) ) {

    // on récupère les infos saisies et postées par l'utilisateur'
    $identifiant = !empty($_POST['identifiant']) ? $_POST['identifiant'] : '';
    $mdp = !empty($_POST['mdp']) ? $_POST['mdp'] : '';

    // vérifications des données saisies
    $identifiantValide = filter_input(INPUT_POST, 'identifiant', FILTER_VALIDATE_EMAIL);
    $mdpValide = filter_input(INPUT_POST, 'mdp', FILTER_DEFAULT);

    if (!$identifiantValide) {
        $msgIdentifiant = "Veuillez renseigner l'identifiant au format @domainName";
    }
    if (!$mdpValide) {
        $msgMdp = "Veuillez renseigner le mot de passe";
    }

    if ($identifiantValide && $mdpValide) {
        //On demande au server de demarrer une session
        session_start();

        // Destruction de toutes les variables de session
        session_unset();

        //On mets les informations de connexion en session
        $_SESSION['identifiant'] = $identifiant;
        $_SESSION['mdp'] = $mdp;

        // création d'une variable de session pour la réponse de l'utilisateur
        $_SESSION['reponse'] = null;

        // On se connecte à la BDD
        $connexion = db_connexion();

        //Instruction sql de lecture
        $sql = "select * from users order by idUser";

        $req_preparee = $connexion->prepare($sql);

        //On exécute la requète
        $req_preparee->execute();

        // On encapsule le résultat dans la variable $users
        $users = $req_preparee->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($users);

        foreach ($users as $user){
            if( ($identifiant === $user['email']) && ($mdp === $user['password']) ) {
                // On met en session l'id de l'utilisateur
                $_SESSION["idUser"] = $user['idUser'];
                $_SESSION["prenom"] = $user['prenom'];
                header("Location:game.php");
                exit();
            } else {
                header("Location:index.php");
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Login Page</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- FontAwesome KIT -->
    <script src="https://kit.fontawesome.com/609c0c060b.js" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.css" />
    <link rel="stylesheet" href="assets/css/style.css" />

</head>
<body>
    <header class="col-md-12 container-fluid">
        <!--Barre de Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index.php" target="_blank">
                <i class="fab fa-phoenix-framework"></i>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-md-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                </ul>
            </div>
        </nav>

    </header>

    <main class="container">
        <div id="comment" >
            <h2>Accueil</h2>
            <p>
                Vous êtes actuellement sur la page de login.<br>
                Vous avez accès au bouton<strong><em> Register </em></strong> pour créer votre compte si vous n'en avez pas un.
            </p>
        </div>

        <!-- Contenu page de login -->
        <div id="login_form" >
            <h3>Login Form</h3>
            <form method="post" autocomplete="off">

                <!-- On récupère l'idUser via l'input de type "hidden" -->
                <input type="hidden" name="id"
                       value="<?php echo $id = ( !empty($user['idUser']) ?  $user['idUser'] : ''  )?>">

                <div class="form-group">
                    <label for="identifiant">Identifiant</label>
                    <input type="email" class="form-control" id="identifiant" name="identifiant" placeholder="user@domain">
                </div>
                <div class="form-group">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Votre mot de passe">
                </div>
                <button type="submit" class="btn btn-success">Valider</button>
                <button type="reset" class="btn btn-danger" style="float: right">Reset</button>
            </form>
        </div>

    </main>

    <footer id="footer" class="container fixed-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-8 mx-auto">
                    <p class="copyright text-center">Copyright &copy; Touleps 2020 | pour dwwm-asnieres</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="assets/js/jquery.js" defer></script>
    <script src="assets/js/bootstrap.bundle.min.js" defer></script>
    <script src="assets/js/bootstrap.min.js" defer></script>
    <script src="assets/js/script.js" defer></script>
</body>
</html>
