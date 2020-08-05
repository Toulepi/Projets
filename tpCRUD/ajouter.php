<?php
    session_start();
    require_once "functions/app_utils.php";

    //var_dump($_SESSION);

?>
<!doctype html>
<html lang="fr">
<head>
    <title>Ajouter Message</title>
    <meta name="description" content="page de l'utilisateur"/>
    <meta name="author" content=""/>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FontAwesome KIT -->
    <script src="https://kit.fontawesome.com/609c0c060b.js" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.css"/>
    <link rel="stylesheet" href="assets/css/style.css"  />
</head>

<body>
<div class="container">
    <div class="col-md-12">
        <!--BAR DE NAVIGATION-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">

            <a class="navbar-brand" href="index.php">
                <img class="logo" src="assets/img/j4l_logo.svg" width="50em" height="50em" alt="Logo j4l">
            </a>
            <a class="nav-link" href="#">Blog</a>
            <a class="nav-link" href="index.php">Accueil</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="navbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-md-auto">
                    <li class="nav-item">
                        <a  class="nav-link" href="user.php">Message </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </nav>

        <form method="post" autocomplete="off" style="width: 50%; margin: 1em auto">

            <!-- On récupère l'idUser via l'input de type "hidden" -->
            <input type="hidden" name="id"
                   value="<?php echo $id = ( !empty($user['idUser']) ?  $user['idUser'] : ''  )?>">
            <div class="form-group">
                <label for="titre">Titre</label>
                <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre du message">
            </div>

            <div class="form-group">
                <label for="contenu">Contenu</label>
                <input type="text" class="form-control" id="contenu" name="contenu" placeholder="Taper le texte du message">
            </div>

            <button type="submit" class="btn btn-success">Valider</button>
            <button type="reset" class="btn btn-danger" style="float: right">Reset</button>
        </form>

    </div>

<?php
    $method = $_SERVER['REQUEST_METHOD'];
    if ( ($method == "POST") && !empty($method) ){

        $titre = !empty($_POST['titre']) ? $_POST['titre'] : '';
        $contenu = !empty($_POST['contenu']) ? $_POST['contenu'] : '';

        //On fait des vérifications sur les saisies
        $titreValide = ( strlen(trim($titre)) !== 0 ); // on verifie que le 'input' sans les espaces n'est pas vide
        $contenuValide = ( strlen(trim($contenu)) !== 0 );

        if (!$titreValide){
        $msgTitre = "Le titre est requis pour ce champ";
        }
        if (!$contenuValide){
        $msgContenu = "Le contenu est requis pour ce champ";
        }

        if ($titreValide && $contenuValide)
        {
            // On se connecte à la BDD
            $connexion = db_connexion();

            //Instruction sql d'insertion
            $sql = "insert into dwwm_db.messsage(titre, contenu, dateInsertion,idUser)
            values (?,?,?,?)";

            //On prépare la requête
            $req_preparee = $connexion->prepare($sql);

            try {
            // On execute la requête en passant les valeurs
            $req_preparee->execute([$titre,$contenu,date('ddmmyy' ),$_SESSION['idUser']]);

            header("user.php");
            exit();
            } catch(Exception $e){
            exit("<h2 class='text-danger text-center'>Une erreur est survenue </h2>");
            }

        }
    }
?>

<?php
Pied_page();
?>

