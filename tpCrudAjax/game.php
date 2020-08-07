<?php
    session_start();
    //print_r($_SESSION) //show all the session variable values for the user in session
?>

<!doctype html>
<html lang="fr">
<head>
    <title>Product Game</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/609c0c060b.js" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
</head>

<body>
<div class="container">
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="index.php">
                <i class="fab fa-phoenix-framework"></i>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-md-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Deconnexion</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="">
        <form id="game-form" method="post">
            <div id="titre"><h3>JEU DE LA MULTIPLICATION</h3></div>
            <input id="id" type="hidden" name="id">

            <h4 id="msg-defi"><?= $_SESSION["prenom"] ?> voici votre défi du jour</h4>

            <?php
                $x = rand(10,99);
                $y = rand(10,99);
                echo "<h3>".$x.' x '.$y."</h3>";
                $product = $x*$y;

                var_dump($product);

                // On modifie les variables de session 'product' et 'productString'
                $_SESSION["product"] = $product;
                $_SESSION["productString"] = $x.' x '.$y;

                //var_dump($_SESSION["product"]);
                //var_dump($_SESSION["productString"]);
            ?>

            <div class="form-group">
                <label for="reponse"></label>
                <input type="number" class="form-control" id="reponse" placeholder="Votre réponse ici" name="reponse" required>
            </div>

             <?php
             /*
                //var_dump((int)$_SESSION['reponse']);
                //var_dump($_SESSION['product']);

                 if ( (int)$_SESSION['reponse'] == $_SESSION["product"]) {

                     echo "<h4 id='reponse' style='color: #1e7e34'>" . 'Le résultat est correct: Félicitions!!!'. "</h4>";
                     //$correct = 'OUI';

                 } else {

                     echo "<h4 style='color: red'>" . 'Le résultat est incorrect: essayez encore!!!'."</h4>";
                    // $correct = 'NON';
                 }
                */
            ?>
            <br>
            <button id="submit_ajouter" type="submit" class="btn btn-success" >Valider</button>
        </form>
    </div>
    <div class="score">
        <table class="table table-hover">
            <thead class="thead-light text-center">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">MULTIPLICATION</th>
                <th scope="col">RESPONSE</th>
                <th scope="col">CORRECT ?</th>
            </tr>
            </thead>
            <tbody id="score-body"></tbody>
        </table>
    </div>
</div>

<footer id="footer" class="container">
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


