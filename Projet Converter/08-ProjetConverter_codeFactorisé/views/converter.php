<?php
session_start();

if (!empty($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $mdp = $_SESSION['mdp'];

    //Si le login et mdp ne correspondent pas, on est rediré sur la page de login
    if (($mdp !== "Password123") || (strtolower($email) !== "joachim@dawm.ge")) {
        //On est redirigé vers la page de login
        header("Location:login.php");
        exit();
    }
}

if (!empty($_POST['celsius'])) {
    $celsius = $_POST['celsius'];

    if (is_numeric($celsius)) {
        $fahrenheit = $celsius * 9 / 5 + 32;
    }
}
?>

<!--Insertion du header-->
<?php
require_once "header.php"
?>
<div class="appForm">
    <form method="post">
        <div class="form-group">
            <label for="celsius">Degré Celsius</label>
            <input type="text" class="form-control" placeholder="Entrez la valeur de la temperature en °C"
                   id="celsius"
                   name="celsius">
        </div>

        <button type="submit" class="btn btn-valider">Valider</button>
        <button type="reset" class="btn btn-reset float-right">Effacer</button>
    </form>
</div>
<div id="message">
    <?php
    if (!empty($celsius) && is_numeric($celsius)) {
        echo "<div id='resultat'>$fahrenheit °F</div>";
    } elseif (!empty($celsius) && !is_numeric($celsius)) {
        echo "<div id='erreur'>Saisie non valide</div>";
    }
    ?>
</div>

<!--Insertion du footer-->
<?php
require_once "footer.php"
?>
<script src="../public/js/monJs.js"></script>
