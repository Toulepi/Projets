<?php

    require "functions/app_functions.php";
    build_header("Login Page");

?>

        <!-- Debut Contenu-->

        <div>
            <h2>Page de login</h2>
            <form autocomplete="off">
                <div class="form-group">
                    <label for="email">Identifiant au format @</label>
                    <input type="email" class="form-control" id="email">
                </div>
                <div class="form-group">
                    <label for="mdp">Password</label>
                    <input type="password" class="form-control" id="mdp">
                </div>

                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>

        <!-- Fin Contenu-->

<?php
    require_once "functions/app_functions.php";
    build_footer();
?>

