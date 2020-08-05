<?php
    require_once "functions/app_functions.php";

    // On récupère la méthode GET ou POST de la requête
    $method = $_SERVER['REQUEST_METHOD'];

    //echo "<h3>".$method."</h3>";
    //var_dump($_POST);

    //On vérifie que des données ont été postées
    if ( ($method == "POST") && !empty($method) ){

        // on récupère les infos saisies et postées par le user
        $prenom = !empty($_POST['prenom']) ? $_POST['prenom'] : '';    // si la valeur postée sous le champ 'prenom' n'est pas vide on la récupère sinon on la remplace par une chaîne vide
        $ddn = !empty($_POST['ddn']) ? $_POST['ddn'] : '';
        $fonction = !empty($_POST['fonction']) ? $_POST['fonction'] : '';
        $email = !empty($_POST['email']) ? $_POST['email'] : '';
        $salaire = !empty($_POST['salaire']) ? $_POST['salaire'] : '';

        //On fait des vérifications sur les saisies
        $prenomValide = ( strlen(trim($prenom)) !== 0 ); // on verifie que le 'input' sans les espaces n'est pas vide
        $fonctionValide = ( strlen(trim($fonction)) !== 0 );
        $emailValide = filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        $salaireValide = filter_input(INPUT_POST,'salaire',FILTER_VALIDATE_INT);

        //var_dump($prenomValide);

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

            //Instruction sql d'insertion
            $sql = "insert into employes(prenom, ddn, fonction, email, salaire)
                    values (?,?,?,?,?)";

            //On prépare la requête
            $req_preparee = $connexion->prepare($sql);

            try {
                /*

                 Dans le rendu du projet il faudra que le prénom soit sur la forme "Prenom"
                penser à utiliser une fonction 'Substring()'
                */
                // On execute la requête en passant les valeurs
                $req_preparee->execute([strtoupper($prenom),$ddn,$fonction,$email,$salaire]);  // Alternative à la méthode "BindValue()"

                // On est redirigé vers la page "employes.php" en cas de succès
                header("Location:employes.php");
                exit();  // Bonne Pratique, on arrête l'exécution du code
            } catch(Exception $e){
                // On lève un exception en cas d'échec
                exit("<h2 class='text-danger text-center'>Une erreur est survenue </h2>");
            }

        }
    }
?>

<?php
    build_header("Page Ajouter");
?>

    <div>
        <h2>Nouvel Employé</h2>
        <div>
            <form method="post" autocomplete="off">
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" class="form-control" id="prenom" placeholder="Prénom" name="prenom" required>

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
                    <input type="date" class="form-control" id="ddn" name="ddn" required>
                </div>
                <div class="form-group">
                    <label for="fonction">Fonction</label>
                    <input type="text" class="form-control" id="fonction" placeholder="Fonction" name="fonction" required>

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
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>

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
                    <input type="number" class="form-control" id="salaire" placeholder="Salaire" name="salaire" required>

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
