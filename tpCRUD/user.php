<?php
    session_start();

    require_once "functions/app_utils.php";
    $id = $_GET['idUser'];

    var_dump($_SESSION);

    // connexion à la BDD dwwm_db
    $connexion = db_connexion();

    //Instruction sql de lecture
    $sql = "select * from dwwm_db.users where idUser=$id";
    $sql1 = "select * from dwwm_db.messsage where idUser=$id";

    $req_preparee = $connexion->prepare($sql);
    $req_preparee1 = $connexion->prepare($sql1);

    //On exécute la requète
    $req_preparee->execute();
    $req_preparee1->execute();

    // On encapsule le résultat dans la variable $users
    $user = $req_preparee->fetchAll(PDO::FETCH_ASSOC);
    $userMessage = $req_preparee1->fetchAll(PDO::FETCH_ASSOC);
    //var_dump($user);
    //var_dump($userMessage);
?>

<!doctype html>
<html lang="fr">
    <head>
        <title>Page User</title>
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
                                <!--
                                <label for="msg"></label>
                                <select name="msg" id="msg" class="nav-link" >
                                    <option>Message</option>
                                    <option value="Liste" >Liste</option>
                                    <option value="Ajouter">Ajouter</option>
                                </select>
                                -->
                                <a  class="nav-link" href="">Liste </a>
                                <a  class="nav-link" href="ajouter.php" target="_blank">Ajouter </a>

                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Déconnexion</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="msg">
            <h3>Aucun message posté actuellement</h3>
        </div>

            <?php
                //$option = isset($_GET['msg']) ? $_GET['msg'] : false;
                //var_dump($_GET['msg']);
               // if ($option) {
            echo "Voici vos différents messages postés";
                    for( $i = 0; $i < count($userMessage) ;$i++ ){
                        echo "<h3>".$userMessage[$i]['Titre']."</h3> <br>";
                        echo "<h5>". $userMessage[$i]['dateInsertion']."</h5><br>";
                        echo "<h6>".$userMessage[$i]['Contenu']."</h6><br>";
                      // echo "<button type="submit" class="btn btn-danger">Supprimer</button>";

                   // }

               // } else {

                 //   exit();
                }

            ?>
        <!--<a href="modifierMessage.php" ?  id=$id class="btn btn-info">Modifier</a> -->

    </div>

    <?php
        $method = $_SERVER['REQUEST_METHOD'];
        if ( ($method === "GET") && !empty($_GET['id']) ){

            $id = htmlspecialchars( $_GET['id'] );  // protection contre les injections

            $sql = "DELETE FROM dwwm_db.messsage WHERE id = $id";

            $connexion = db_connexion();
            $req_preparee = $connexion->prepare($sql);
            $req_preparee->execute([$id]);

    }

    ?>

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
    <script defer src="assets/js/jquery.js"></script>
    <script defer src="assets/js/bootstrap.bundle.min.js"></script>
    <script defer src="assets/js/bootstrap.min.js"></script>
</body>
</html>
