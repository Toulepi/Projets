<?php

    require_once "functions/app_functions.php";

    $connexion = db_connexion();

    // On définie la variable page pour la pagination
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;  //$_GET['page'] existe une fois que l'on clique sur le bouton suivant

    //On définit le nombre d'enregistrements par page
    $nb_employes_par_page = 5;

    //Requète sql préparee
    $sql = "SELECT * FROM Employes order by id limit ?, ?";  // voir la doc sql pour comprendre la fonction de "limit"

    $req_preparee = $connexion->prepare($sql);  //permet d'eviter des injections, on obtient une requete sécurisée

    $req_preparee->bindValue(1,($page-1)*$nb_employes_par_page,PDO::PARAM_INT); // permet de définir le premier paramètre de la fonction "limit"
    $req_preparee->bindValue(2,$nb_employes_par_page,PDO::PARAM_INT);               // permet de définir le second paramètre de la fonction "limit"

    //On exécute la requète
    $req_preparee->execute();

    // On encapsule le résultat dans la variable $employes
    $employes = $req_preparee->fetchAll(PDO::FETCH_ASSOC);  // récupération des informations sous forme associative
    //var_dump($employes);

    // Nombre total des employés en BDD
    $nb_employes_par_page = $connexion->query("select count(*) from employes") -> fetchColumn();



?>

<?php
    build_header("Page Employés");
?>

<h2>Liste des employés</h2>
<a href="employe_ajouter.php" class="btn btn-info">Créer</a>
<div>

    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Prénom</th>
            <th scope="col">Date Naiss.</th>
            <th scope="col">Fonction</th>
            <th scope="col">Email</th>
            <th scope="col">Salaire</th>
            <th scope="col" colspan="3">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ($employes as $employe){
                //Utilisation d'un heredoc comme délimiteur
            echo<<<EOT
                <tr>
                  <td>{$employe['id']}</td>
                  <td>{$employe['prenom']}</td>
                  <td>{$employe['ddn']}</td>
                  <td>{$employe['fonction']}</td>
                  <td>{$employe['email']}</td>
                  <td>{$employe['salaire']} €</td>
                  
                  <td>
                    <a href="employe-modifier.php ? id={$employe['id']}">Modifier</a>  <!-- ici '?' permet de récupérer l'id via la création et l'initialisation d'un paramètre "id" -->
                  </td>
                  <td>
                    <a href="employe_supprimer.php ? id={$employe['id']}">Supprimer</a>
                  </td>
                  <td>
                    <a href="employe_infos.php ? 
                                    prenom={$employe['prenom']},
                                    Date Naiss={$employe['ddn']},
                                    fonction={$employe['fonction']},
                                    email={$employe['email']},
                                    salaire={$employe['salaire']}
                            " target="_blank">Détail
                    </a>
                  </td>
                </tr>
EOT;

            }

        ?>

        </tbody>
    </table>

</div>

<?php
    build_footer();
?>