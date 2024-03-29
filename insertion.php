<?php
session_start();
include "functions.php";
include "formulaires.php";
noSessionRedirect();
noProfRedirect();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertion Notes - GradeUp</title>
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
                    <h1 class="text-center">Insertion de notes</h1>
                </div>
            </div>
            <form action="insertion.php?action=insert" class="text-center p-3" method="post">
                <?php
                //affiche le formulaire Insertion
                formulaireInsertion();
                ?>
            </form>
            <?php
            if (isset($_GET["action"])) {
                if (($_GET['action'] == "insert")) {
                    //Vérifie la présence de tous les paramètres
                    if (isset($_POST['login_insert']) && isset($_POST['matiere_insert']) && isset($_POST['type_insert']) && isset($_POST['note_insert']) && isset($_POST['coeff_insert'])) {
                        //Si l'insertion à fonctionner : afficher un message de réussite et afficher toutes les notes sinon un message d'erreur
                        if (insertionNote($_POST['login_insert'], $_POST['matiere_insert'], $_POST['type_insert'], $_POST['coeff_insert'], $_POST['note_insert'])) {
                            echo "<div class='alert alert-success' role='alert'>La note a bien été insérée</div>";
                            afficheNotes(getAllNotes());
                        } else {
                            echo "<div class='alert alert-danger' role='alert'>La note n'a pas pu être insérée</div>";
                        }
                    }
                }
            }
            ?>
            <div id="under-footer"> </div>
    </main>
    <footer id="footer" class="footer fixed-bottom bg-dark light-text">
        <p class="var_dump">
            <?php
            var_dump($_POST);
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