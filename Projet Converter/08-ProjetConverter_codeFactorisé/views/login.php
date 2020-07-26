<?php
//On demande au server de demarrer une session
session_start();

//On test si le user a effectuer une saisie
if (!empty($_POST['email'])) {
    //On recupere la valeur de l'email
    $email = $_POST['email'];
    //On recupere la valeur du mot de passe
    $mdp = $_POST['mdp'];

    //On mets les informations de connexion en session
    $_SESSION['email'] = $email;
    $_SESSION['mdp'] = $mdp;

    //On le redirige vers la page de conversion
    header("Location:converter.php");
    exit();
}
?>

<!--Insertion du header-->
<?php
require_once "header.php"
?>

    <div class="appForm">
        <form method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" placeholder="Entrez votre email comme identifiant"
                       id="email"
                       name="email">
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

    <!--Insertion du footer-->
<?php
require_once "footer.php"
?>