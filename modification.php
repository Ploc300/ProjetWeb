<?php
session_start();
include "functions.php";
include "formulaires.php";
noSessionRedirect();
// Si pas de compte porf/admin on redirige vers la page d'accueil
noProfRedirect()
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification Notes - GradeUp</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://www.google.com/recaptcha/api.js?render=6LdgyFQmAAAAAAtMIIaC-UvQjARb2IEcdNw6qrPq"></script>
</head>

<body>
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand">
                <div>
                    <img src="assets/icons/logo.png" alt="GradeUp Logo" class="d-inline-block align-text-top">
                    GradeUp
                </div>
                <div class="profile">
                    <img src="<?php echo getProfilePicture($_SESSION['uLogin']); ?>" alt="Profile Icon"
                        class="d-inline-block align-text-top">
                    <?php
                    echo ucfirst(explode('@', $_SESSION['uLogin'])[0]);
                    ?>
                </div>
            </a>
            <div class="" id="navbarNav">
                <ul class="nav justify-content-center">
                    <?php
                    menu();
                    ?>
                </ul>
            </div>
        </div>
    </nav>


    <header>
        <ul class="background">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
        <?php
        echo "<h2>Vous êtes sur la page: " . ucfirst(explode('.', basename($_SERVER['PHP_SELF']))[0]) . "</h2>";
        ?>
    </header>

    <main>
        <div class="container mx-auto">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center">Modification des notes</h1>
                </div>
            </div>
            <?php
            // Si une note a été sélectionnée afficher le formulaire de modification
            if (isset($_GET['id'])) {
                ?>
                <form action="modification.php?action=modif" class="align-items-center text-center p-3" method="post">
                    <?php
                    FormulaireModification($_GET['id']);
                    ?>
                </form>
                <?php
            }
            // Si le formulaire a été envoyé vérifier toutes les informations
            if (isset($_GET["action"]) && isset($_POST['captcha'])) {
                // Verification du captcha
                if (($_GET['action'] == "modif" && ($_POST['captcha'] == $_SESSION['code']))) {
                    // Verification que toutes les informations sont présentes
                    if (isset($_POST['id_modif']) && isset($_POST['login_modif']) && isset($_POST['matiere_modif']) && isset($_POST['type_modif']) && isset($_POST['note']) && isset($_POST['coeff'])) {
                        // Si la modification a réussi afficher un message de succès sinon un message d'erreur
                        if (modificationNote($_POST['id_modif'], $_POST['matiere_modif'], $_POST['type_modif'], $_POST['note'], $_POST['coeff'])) {
                            echo "<div class='alert alert-success' role='alert'>La note a bien été modifiée</div>";
                        } else {
                            echo "<div class='alert alert-danger' role='alert'>La note n'a pas pu être modifiée</div>";
                        }
                    }
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Le captcha est incorrect</div>";
                }
            }
            ?>
            <!-- Formulaire de tri pour la sélection des notes -->
            <form action="#" class="text-center p-3">
                <div class="form-group">
                    <input type="text" class="form-control" value="" name="login" id="login" placeholder="Login">
                </div>
                <div class="form-group">
                    <select class="form-control" name="matiere" id="matiere">
                        <option value="all" selected>Toutes les matières</option>
                        <?php
                        foreach (getMatieres() as $matiere) {
                            echo "<option value='" . $matiere['NoMat'] . "'>" . $matiere['NomMat'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" name="type" id="type">
                        <option value="all" selected>Tous les types</option>
                        <?php
                        foreach (getTypeNotes() as $type) {
                            echo "<option value='" . $type['NoNote'] . "'>" . $type['NomNote'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-dark">Rechercher</button>
            </form>
            <?php
            // Affichage dynamique des notes en fonctions des paramètres de tri
            if (isset($_GET['login']) && isset($_GET['matiere']) && isset($_GET['type'])) {
                $notes = getNotesByEtu(getNotesByMat(getNotesByType(getAllNotes(), $_GET['type']), $_GET['matiere']), $_GET['login']);
                if (empty($notes)) {
                    echo "<p class='text-center'>Aucune note trouvée</p>";
                } else {
                    afficheNotes($notes);
                }
            } else { // Si aucun paramètre n'est donné afficher toutes les notes
                afficheNotes(getAllNotes());
            }
            ?>
        </div>
        <div id="under-footer"> </div>
    </main>
    <footer id="footer" class="footer fixed-bottom bg-dark light-text">
        <p class="var_dump">
            <?php

            ?>
        </p>
        <div class="container text-center">
            <span>Alexis PENCRANE - Noann LOSSER | 2023 | All right reserved &copy;</span>
        </div>
    </footer>


    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById("under-footer").style.height = document.getElementById("footer").offsetHeight + "px";
    </script>
</body>


</html>