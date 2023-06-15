<?php
session_start();
include "functions.php";
// Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
noSessionRedirect();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - GradeUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src='js/function.js'></script>
</head>

<body>
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand">
                <div>
                    <img src="assets/icons/logo.png" alt="GradeUp Logo" class="d-inline-block align-text-top">
                    GradeUp
                </div>
                <!-- Affiche le profil de l'utilisateur dans la navbar -->
                <div class="profile">
                    <img src="<?php echo getProfilePicture($_SESSION['uLogin']); ?>" alt="Profile Icon"
                        class="d-inline-block align-text-top">
                    <?php
                    // sépare la premiere partie du mail pour afficher le login
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
    </header>

    <main>
        <?php
        // Affiche le nom de la page
        echo "<h2>Vous êtes sur la page: " . ucfirst(explode('.', basename($_SERVER['PHP_SELF']))[0]) . "</h2>";
        // Si s'ession etudiant alors affiche les notes de l'etudiant
        if ($_SESSION['uRole'] == "utilisateur") {
            echo "<h4>Voici vos notes</h4>";
            echo "<br><div class='container'>";
            echo "<p>Vous avez une moyenne de " . getMoyenneByEtu($_SESSION['uLogin']) . "</p>";
            // Recupere toutes les notes de l'etudiant et les affiche
            afficheNotes(getNotesByEtu(getAllNotes(), $_SESSION['uLogin']));
            echo "</div>";
        } else { // Si session prof/admin affiche le nom de l'apli pour ne pas laisser de vide
            ?>
        <ul class="indexAnim">
            <li>GradeUP!</li>
        </ul>
            <?php
        }
        ?>
        <div id="under-footer"> </div>
    </main>

    <footer id="footer" class="footer fixed-bottom bg-dark light-text">
        <p class="var_dump">
            <!-- Zone de test pour ne pas oublier les oublier dans la version finale -->
            <?php

            ?>
        </p>
        <div class="container text-center">
            <span>Alexis PENCRANE - Noann LOSSER | 2023 | All right reserved &copy;</span>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script>
        document.getElementById("under-footer").style.height = document.getElementById("footer").offsetHeight + "px";
    </script>
</body>


</html>