<?php
    require_once "functions/app_utils.php";
    Entete_page("Page Login");
?>

<?php
    // On récupère la méthode GET ou POST de la requête
    $method = $_SERVER['REQUEST_METHOD'];

    //On vérifie que des données ont été postées
    if ( ($method == "POST") && !empty($method) ) {

        // on récupère les infos saisies et postées par le user

        $identifiant = !empty($_POST['identifiant']) ? $_POST['identifiant'] : '';
        $mdp = !empty($_POST['mdp']) ? $_POST['mdp'] : '';

        //On fait des vérifications sur les saisies
        $identifiantValide = filter_input(INPUT_POST, 'identifiant', FILTER_VALIDATE_EMAIL);
        $mdpValide = filter_input(INPUT_POST, 'mdp', FILTER_DEFAULT);

        if (!$identifiantValide) {
            $msgPrenom = "Le prénom est requis pour ce champ";
        }
        if (!$mdpValide) {
            $msgMdp = "Veuillez renseigner le mot de passe";
        }

        if ($identifiantValide && $mdpValide) {
            //On demande au server de demarrer une session
            session_start();

            //On mets les informations de connexion en session
            $_SESSION['identifiant'] = $identifiant;
            $_SESSION['mdp'] = $mdp;

            // On se connecte à la BDD
            $connexion = db_connexion();

            //Instruction sql de lecture
            $sql = "select * from dwwm_db.users order by idUser";

            $req_preparee = $connexion->prepare($sql);

            //On exécute la requète
            $req_preparee->execute();

            // On encapsule le résultat dans la variable $users
            $users = $req_preparee->fetchAll(PDO::FETCH_ASSOC);

            foreach ($users as $user){
                if( ($identifiant === $user['email']) && ($mdp === $user['password']) )
                {
                    $id = $user['idUser'];

                    // On récupère l'id du user qui est en session
                    $_SESSION["idUser"] = $id;

                    //on est dirigé vers la page de l'utilisateur en utilisant une variable d'url pour récupérer idUser
                    header("Location:user.php");  // on aurait pu utiliser une variable d'url comme suit: ?idUser=$id
                    //var_dump($user);
                    // il faudra récupérer l'idUser afin de construire la page User
                    exit();
                } else {
                    header("Location:login.php");
                }
            }

        }
    }
?>

    <!-- Contenu page de login -->
    <div id="login_form" style="width: 50%;margin: 2em auto">
        <h2 style="text-align: center">Login Form</h2>
        <form method="post" autocomplete="on">

            <!-- On récupère l'idUser via l'input de type "hidden" -->
            <input type="hidden" name="id"
                   value="<?php echo $id = ( !empty($user['idUser']) ?  $user['idUser'] : ''  )?>">

            <div class="form-group">
                <label for="identifiant">Identifiant</label>
                <input type="email" class="form-control" id="identifiant" name="identifiant" placeholder="user@domain">
            </div>
            <div class="form-group">
                <label for="mdp">Mot de passe</label>
                <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Votre mot de passe">
            </div>
            <button type="submit" class="btn btn-success">Valider</button>
            <button type="reset" class="btn btn-danger" style="float: right">Reset</button>
        </form>
    </div>

<?php
    Pied_page();
?>
