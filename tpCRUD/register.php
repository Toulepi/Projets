<?php
require_once "functions/app_utils.php";

    // On récupère la méthode GET ou POST de la requête
    $method = $_SERVER['REQUEST_METHOD'];

    //On vérifie que des données ont été postées
    if ( ($method == "POST") && !empty($method) ){

    // on récupère les infos saisies et postées par le user
    $prenom = !empty($_POST['prenom']) ? $_POST['prenom'] : '';    // si la valeur postée sous le champ 'prenom' n'est pas vide on la récupère sinon on la remplace par une chaîne vide
    $identifiant = !empty($_POST['identifiant']) ? $_POST['identifiant'] : '';
    $mdp = !empty($_POST['mdp']) ? $_POST['mdp'] : '';

    //On fait des vérifications sur les saisies
    $prenomValide = ( strlen(trim($prenom)) !== 0 ); // on verifie que le 'input' sans les espaces n'est pas vide
    $identifiantValide = filter_input(INPUT_POST,'identifiant',FILTER_VALIDATE_EMAIL);
    $mdpValide = filter_input(INPUT_POST,'mdp',FILTER_VALIDATE_INT);

        if (!$prenomValide){
            $msgPrenom = "Le prénom est requis pour ce champ";
        }
        if (!$identifiantValide){
            $msgIdentifiant = "L'identifiant est requis pour ce champ";
        }
        if (!$mdpValide){
            $msgMdp = "Veuillez renseigner le mot de passe";
        }

        if ($prenomValide && $identifiantValide && $mdpValide)
        {
            $connexion = db_connexion();
            $sql = "insert into Users(prenom, email,password) values (?,?,?)";
            $req_preparee = $connexion->prepare($sql);
            try {
                // On execute la requête en passant les valeurs
                $req_preparee->execute([$prenom,$identifiant,$mdp]);
                // Redirection vers la page de login
                header("Location:login.php");
                exit();
            } catch(Exception $e){
                exit("<h2 class='text-danger text-center'>Une erreur est survenue </h2>");
            }
        }
    }

    Entete_page("Page Register");
?>

<div id="register-form" style="width: 50%;margin: .1em auto">
    <form action="" method="post" class="">
        <div class="">
            <h2 style="text-align: center">Register Form</h2>
            <p style="text-align: center">Veuillez remplir ce formulaire pour créer un compte</p>
        </div>
        <div class="form-group">
            <label for="prenom"><b>Prénom</b></label>
            <input type="text" placeholder="Entrer votre prénom" name="prenom" class="form-control" id="prenom">
        </div>
        <div class="form-group">
            <label for="identifiant"><b>Identifiant</b></label>
            <input type="email" placeholder="Votre identifiant" name="identifiant" id="identifiant" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="mdp"><b>Mot de passe</b></label>
            <input type="password" placeholder="Entrer votre mot de passe" name="mdp" id="mdp" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="r_mdp"><b>Confirmer votre mot de passe</b></label>
            <input type="password" placeholder="Repéter votre mot de passe" name="r_mdp" id="r_mdp" class="form-control" required>
        </div>
            <button type="submit" class="btn btn-success ">Valider</button>
            <button type="reset" class="btn btn-danger" style="float: right">Reset</button>
    </form>
</div>



<?php
require_once "functions/app_utils.php";
Pied_page();
?>
