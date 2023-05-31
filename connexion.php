<?php
session_start();
include "functions.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - GradeUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand">
                <img src="assets/icons/logo.png" alt="GradeUp Logo" class="d-inline-block align-text-top">
                GradeUp
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
        if (isset($_GET['action'])) {
            if ($_GET['action'] == "logout") {
                session_destroy();
                header("Location: connexion.php");
            }
        }
        if (!isset($_SESSION['uRole'])) {
            connexion();
        } else {
            echo "<h1 class='text-center'>Vous êtes déjà connecté</h1>";
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            ;
        }
        ?>
    </main>

    <footer class="footer fixed-bottom bg-dark light-text">
        <p class="text-center">
            <span>Compte de test: admin@iut.fr:admin prof1@iut.fr:prof1 etu1@iut.fr:etu1</span>
        </p>
        <div class="container text-center">
            <span>Alexis PENCRANE - Noann LOSSER | 2023 | All right reserved &copy</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>