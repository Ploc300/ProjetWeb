<?php
session_start();
include "functions.php";
include "formulaires.php";
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
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
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
            <form action="index.php?action=selection" class="text-center p-3" method="post">
                <?php
                formulaireIndex();
                ?>
            </form>
            <?php
            if (isset($_POST['login_index']) && isset($_POST['matiere']) && isset($_POST['type'])) {
                $notes = getNotesByEtu(getNotesByMat(getNotesByType(getAllNotes(), $_POST['type']), $_POST['matiere']), $_POST['login_index']);
                if (empty($notes)) {
                    echo "<p class='text-center'>Aucune note trouvée</p>";
                } else {
                    afficheNotes($notes);
                }
            } 
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


    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script>
        // Permet de fixer le footer en bas de page
        document.getElementById("under-footer").style.height = document.getElementById("footer").offsetHeight + "px";
    </script>
</body>


</html>