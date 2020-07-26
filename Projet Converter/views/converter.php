<?php
    session_start();

    if ( !empty($_SESSION['email']) ){   // est-ce que la session n'est pas vide et contient un email ?

        $email = $_SESSION['email'];
        $mdp = $_SESSION['mdp'];

        //si le login (email) et mdp ne correspondent pas, on est redirigé sur la page de login

        if ($mdp !== "Password" || strtolower($email) !== strtolower("toulepi@bami.cm")) {
            #on est redirigé vers la page de login
            header("Location:login.php");
            exit();
        }
    }

    if (!empty($_POST['celsius'])){

        $celsius = $_POST['celsius'];

        if (is_numeric($celsius)){
            $fahren = $celsius * 9/5 + 32;
        }

    }

?>



<!doctype html>
<html lang="en">
<head>
    <title>Converter Page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../public/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="../public/css/style.css"/>
</head>
<body>

<div class="container">
    <header>
        projet converter
    </header>
    <main>
        <div class="form-header">
            login form
        </div>
        <div class="appForm">
            <form method="post">
                <div class="form-group">
                    <label for="email">Celsius</label>
                    <input type="number" class="form-control" placeholder="Entrez votre valeur en °C"
                           id="celsius"
                            name="celsius">
                </div>

                <button type="submit" class="btn btn-valider">Valider</button>
                <button type="reset" class="btn btn-reset float-right">Effacer</button>
            </form>
        </div>

        <p>
            <?php
                if (is_numeric($celsius)){
                    echo "<h2>$fahren</h2>";
                }

            ?>
        </p>

    </main>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>
</html>


