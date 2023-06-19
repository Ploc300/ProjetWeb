<?php
// Démarrage de la session
session_start();
// Inclusion des fichiers php
include "functions.php";
include "formulaires.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - GradeUp</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <!-- Navbar avec boostrap -->
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand">
                <img src="assets/icons/logo.png" alt="GradeUp Logo" class="d-inline-block align-text-top">
                GradeUp
            </a>
            <div class="" id="navbarNav">
                <ul class="nav justify-content-center">
                    <?php
                    // Affichage d'un menu dynamique en fonction de la session (avec bootsrap)
                    menu();
                    ?>
                </ul>
            </div>
        </div>
    </nav>


    <header>
        <!-- Arrière plan animé en css -->
        <ul class="background">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>

    </header>

    <main>
        <?php
        // Si couple login mdp incorrect afficher message d'erreur
        if (isset($_GET['login'])) {
            if ($_GET['login'] == "error") {
                echo '<div class="container-fluid d-flex justify-content-center align-items-center"><div class="alert alert-danger" role="alert">Erreur de connexion</div></div>';
            }
        }
        // Si bouton de déconnexion cliqué (renvoi vers cette page avec l'action logout) detruire la session et renvoyer vers la page de connexion
        if (isset($_GET['action'])) {
            if ($_GET['action'] == "logout") {
                session_destroy();
                header("Location: connexion.php");
            }
        }
        // Si aucune session afficher le formulaire de connexion
        if (!isset($_SESSION['uRole'])) {
            ?>
            <div class="form-container">
                <form action="functions.php" method="post">
                    <div class="form-group d-flex flex-column align-items-center">
                        <label for="email">Adresse email</label>
                        <input required placeholder="@iut.fr" type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="form-group d-flex flex-column align-items-center">
                        <label for="password" class="text-center">Mot de passe</label>
                        <input required placeholder="Ne partagez pas votre mdp" type="password" class="form-control"
                            id="password" name="password">
                    </div>
                    <div class="form-group d-flex flex-column align-items-center">
                        <button type="submit" class="btn btn-dark">Connexion</button>
                    </div>
                </form>
            </div>
            <?php
        } else { // Sinon afficher un message d'erreur
            echo "<h1 class='text-center'>Vous êtes déjà connecté</h1>";
        }
        ?>
    </main>

    <footer class="footer fixed-bottom bg-dark light-text">
        <!-- Comptes de test -->
        <p class="text-center">
            <span>Compte de test: admin@iut.fr:admin prof1@iut.fr:prof1 etu1@iut.fr:etu1</span>
        </p>
        <div class="container text-center">
            <span>Alexis PENCRANE - Noann LOSSER | 2023 | All right reserved &copy;</span>
        </div>
    </footer>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>