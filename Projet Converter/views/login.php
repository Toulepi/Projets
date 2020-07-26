<?php
//On demande au server de demarrer une session
session_start();

// On teste si le user a effectuer une saisie
    if (!empty($_POST['email'])){
        // on crée les variables
        $email = $_POST['email'];
        $mdp = $_POST['mdp'];

    // On met les informations de connaexion en session
    $_SESSION['email'] = $email;
    $_SESSION['mdp'] = $mdp;

    #On le redirige vers la page de conversion
    header("Location:converter.php");

    } else {
        //TODO; dans tous les cas on est sur la page

    }



?>

<!doctype html>
<html lang="en">
<head>
    <title>Login Page</title>
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
                    <label for="email">Email</label>
                    <input type="email" class="form-control" placeholder="Entrez votre email comme identifiant"
                           id="email"
                           required name="email">
                </div>
                <div class="form-group">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" class="form-control" placeholder="Entrez votre mot de passe"
                           id="mdp" name="mdp">
                </div>

                <button type="submit" class="btn btn-valider">Valider</button>
                <button type="reset" class="btn btn-reset float-right">Effacer</button>
            </form>
        </div>
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
