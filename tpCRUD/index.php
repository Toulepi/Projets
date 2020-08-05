<?php
    require_once "functions/app_utils.php";
    Entete_page("Page Accueil");
?>


<div id="comment" style="width: 60%; margin: 2em auto;text-align: center">
    <h2 style="text-align: center">Accueil</h2>
    <p>
        Cette application est réalisée avec PHP, elle porte sur les différentes opérations de CRUD.
        Vous êtes actuellement sur la page d'accueil.
        Vous avez accès aux onglets
        <strong><em>Login</em></strong> et <strong><em> Register </em></strong> pour soit vous loger soit créer votre compte.
    </p>
</div>


<!--Insertion du pied de page -->
<?php
    require_once "functions/app_utils.php";
    Pied_page();
?>
