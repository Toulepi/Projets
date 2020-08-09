<?php
    session_start();
    require_once "assets/functions.php";

// On récupère la méthode GET ou POST de la requête
$method = $_SERVER['REQUEST_METHOD'];
if ( ($method == "POST") && !empty($method) ){

    // on récupère les infos saisies et postées par le user
    $prenom = !empty($_POST['prenom']) ? $_POST['prenom'] : '';    // si la valeur postée sous le champ 'prenom' n'est pas vide on la récupère sinon on la remplace par une chaîne vide
    $identifiant = !empty($_POST['identifiant']) ? $_POST['identifiant'] : '';
    $mdp = !empty($_POST['mdp']) ? $_POST['mdp'] : '';

    //On fait des vérifications sur les saisies
    $prenomValide = ( strlen(trim($prenom)) !== 0 );
    $identifiantValide = filter_input(INPUT_POST,'identifiant',FILTER_VALIDATE_EMAIL);
    $mdpValide = filter_input(INPUT_POST,'mdp',FILTER_VALIDATE_INT);

    if (!$prenomValide){
        $msgPrenom = "Le prénom est requis pour ce champ";
    }
    if (!$identifiantValide){
        $msgIdentifiant = "L'identifiant est obligatoire pour ce champ";
    }
    if (!$mdpValide){
        $msgMdp = "Veuillez renseigner le mot de passe";
    }

    if ($prenomValide && $identifiantValide && $mdpValide) {
        $connexion = db_connexion();
        $sql = "insert into Users(prenom, email,password) values (?,?,?)";
        try {

            $req_preparee = $connexion->prepare($sql);
            // On execute la requête en passant les valeurs
            $req_preparee->execute([$prenom,$identifiant,$mdp]);
            // Redirection vers la page de login
            header("Location:index.php");
            exit();
        } catch(Exception $e){
            exit("<h2 class='text-danger text-center'>Une erreur s'est produite </h2>");
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Rgister Page</title>
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
            <a class="navbar-brand" href="#">
                <i class="fab fa-phoenix-framework"></i>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-md-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Login</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="container">
        <div class="comment">
            <h2>Register Form</h2>
            <p>
                Vous êtes actuellement sur la page d'enregistrement.<br>
                Vous avez accès au bouton<strong><em> Login </em></strong> pour vous connecter à votre compte si vous en avez déjà un.
            </p>
        </div>

        <!-- Contenu page de login -->
        <div id="register_form" >
            <form method="post" autocomplete="off">

                <!-- On récupère l'idUser via l'input de type "hidden" -->
                <input type="hidden" name="id"
                       value="<?php echo $id = ( !empty($user['idUser']) ?  $user['idUser'] : ''  )?>">
                <div class="form-group">
                    <label for="identifiant">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre prénom">
                </div>
                <div class="form-group">
                    <label for="identifiant">Identifiant</label>
                    <input type="email" class="form-control" id="identifiant" name="identifiant" placeholder="au format user@domain">
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

