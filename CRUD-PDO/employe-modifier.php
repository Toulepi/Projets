<?php
    require_once "functions/app_functions.php";

    // On récupère la méthode GET ou POST de la requête
    $method = $_SERVER['REQUEST_METHOD'];

    if( ($method === "GET") && empty($_GET['id']) ) {
            header("Location:employes.php");
            exit();
        }

    //On vérifie que des données ont été postées
    if ( ($method === "GET") && !empty($_GET['id']) ){

        $id = $_GET['id'];
        $sql = "select * from employes where id = ?";

        $connexion = db_connexion();
        $req_preparee = $connexion->prepare($sql);
        $req_preparee->execute([$id]);
        $employe = $req_preparee->fetch(PDO::FETCH_ASSOC);

        //var_dump($employe);

        if (!$employe){
            header("Location:employes.php");
        }
    }

        $prenom = '';
        $ddn = '';
        $fonction = '';
        $email = '';
        $salaire = '';

    if ( ($method === "POST") && !empty($_POST) ){

        // on récupère les infos saisies et postées par le user
        $id = !empty($_POST['id']) ? $_POST['id'] : '';
        $prenom = !empty($_POST['prenom']) ? $_POST['prenom'] : '';    // si la valeur postée sous le champ 'prenom' n'est pas vide on la récupère sinon on la remplace par une chaîne vide
        $ddn = !empty($_POST['ddn']) ? $_POST['ddn'] : '';
        $fonction = !empty($_POST['fonction']) ? $_POST['fonction'] : '';
        $email = !empty($_POST['email']) ? $_POST['email'] : '';
        $salaire = !empty($_POST['salaire']) ? $_POST['salaire'] : '';

        //On refait des vérifications sur la saisie
        $prenomValide = ( strlen(trim($prenom)) !== 0 ); // on verifie que le 'input' sans les espaces n'est pas vide
        $fonctionValide = ( strlen(trim($fonction)) !== 0 );
        $emailValide = filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        $salaireValide = filter_input(INPUT_POST,'salaire',FILTER_VALIDATE_INT);

        if (!$prenomValide){
            $msgPrenom = "Le prénom est requis pour ce champ";
        }
        if (!$fonctionValide){
            $msgFonction = "La fonction est requise pour ce champ";
        }
        if (!$emailValide){
            $msgEmail = "L'adresse mail est requise pour ce champ";
        }
        if (!$salaireValide){
            $msgSalaire = "Veuillez renseigner un entier";
        }

        if ($prenomValide && $fonctionValide && $emailValide && $salaireValide)
        {
            // On se connecte à la BDD
            $connexion = db_connexion();

            //Instruction sql de mise à jour
            $sql = "update employes set prenom=?, ddn=?, fonction=?, email=?, salaire=? where id=?";  // on aurait pu écrire where "id= $id" ssi $id était protégé contre les injections via la "commande htmlspecialchars($id)"

            //On prépare la requête
            $req_preparee = $connexion->prepare($sql);

            // On exécute la requête
            $req_preparee->execute([strtoupper($prenom),$ddn,$fonction,$email,$salaire,$id]);

            header("Location:employes.php");
            exit();
        }

    }

?>

<?php
build_header("Page Modifier");
?>

<div>
    <h2>Employé à modifier</h2>
    <div>
        <form method="post" autocomplete="off">
            <!-- On récupère l'id via l'input de type "hidden" -->
            <input type="hidden" name="id"
                   value="<?php echo $id = ( !empty($employe['id']) ?  $employe['id'] : $id  )?>">

            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" class="form-control" id="prenom"
                       placeholder="Prénom" name="prenom"
                       required value="<?php echo $prenom = ( !empty($employe['prenom']) ?  $employe['prenom'] : $prenom  ) ?>">
                <?php
                if (!empty($msgPrenom)){
                    echo<<<EOT
                        <small class="text-danger">{$msgPrenom}</small>
EOT;
                }
                ?>

            </div>
            <div class="form-group">
                <label for="ddn">Date Naiss</label>
                <input type="date" class="form-control" id="ddn" name="ddn"
                       required value="<?php echo $ddn = ( !empty($employe['ddn']) ?  $employe['ddn'] : $ddn  ) ?>">
            </div>
            <div class="form-group">
                <label for="fonction">Fonction</label>
                <input type="text" class="form-control" id="fonction"
                       placeholder="Fonction" name="fonction"
                       required value="<?php echo $fonction = ( !empty($employe['fonction']) ?  $employe['fonction'] : $id  ) ?>">

                <?php
                if (!empty($msgFonction)){
                    echo<<<EOT
                        <small class="text-danger">{$msgFonction}</small>
EOT;

                }
                ?>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email"
                       placeholder="Email" name="email"
                       required value="<?php echo $email = ( !empty($employe['email']) ?  $employe['email'] : $email  ) ?>" >

                <?php
                if (!empty($msgEmail)){
                    echo<<<EOT
                        <small class="text-danger">{$msgEmail}</small>
EOT;

                }
                ?>

            </div>
            <div class="form-group">
                <label for="salaire">Salaire</label>
                <input type="number" class="form-control" id="salaire"
                       placeholder="Salaire" name="salaire"
                       required value="<?php echo $salaire = ( !empty($employe['salaire']) ?  $employe['salaire'] : $salaire  ) ?>">

                <?php
                if (!empty($msgSalaire)){
                    echo<<<EOT
                        <small class="text-danger">{$msgSalaire}</small>
EOT;

                }
                ?>

            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>

</div>

<?php
build_footer();
?>
