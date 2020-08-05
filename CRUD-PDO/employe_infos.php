<?php
    require_once "functions/app_functions.php";
    build_header("Informations Employé");
?>

<div class="container">
    <h5>Informations sur <?php echo $_GET['prenom'] ?><br></h5>
</div>

<?php
    build_footer();
?>


