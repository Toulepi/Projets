<?php
require_once "functions/utils.php";

template_entete("Employés");
?>

<!-- PAGE LISTE DES EMPLOYES -->
<div>
    <h2>Employés</h2>
    <hr>
    <a href="ajouter.php" class="btn btn-primary">Ajouter un employé</a>

    <div>
        Bonjour, vous êtes sur la page liste des employés
    </div>

</div>

<?php
template_pied_page("Employés");
?>