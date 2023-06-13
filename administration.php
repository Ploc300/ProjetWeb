<?php
session_start();
include "functions.php";
include "formulaires.php";
noSessionRedirect();
noAdminRedirect();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - GradeUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/script.js"></script>
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
        <?php
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'ajout':
                    formulaireAjoutAdmin();
                    break;
                case 'supression':
                    formulaireSupressionAdmin();
                    break;
                case 'modification':
                    formulaireModificationAdmin();
                    break;
                case 'afficher':
                    afficheUsers();
                    break;
                case 'uploadImage':
                    echo '<br>';
                    formulaireUploadImage();
                    break;
                case 'deleteImage':
                    formulaireDeleteImage();
                    break;
                case 'afficherLogs':
                    afficherLogs();
                    break;
            }
        } else if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'ajout':
                    if (preg_match('/^assets\/profilepicture\/.*\.png$/', $_POST['image'])) {
                        if ($_POST['captcha'] == $_SESSION['code']) {
                            if (in_array($_POST['statut'], ['administrateur', 'professeur', 'utilisateur'])) {
                                if (ajoutCompte($_POST['login'], $_POST['password'], $_POST['statut'], $_POST['image'])) {
                                    echo "<p class='alert alert-success'>Compte ajouté avec succès</p>";
                                    afficheUsers();
                                } else {
                                    echo "<p class='alert alert-danger'>Erreur lors de l'ajout du compte</p>";
                                }

                            } else {
                                echo "<p class='alert alert-danger'>Le statut doit etre \"administateur\", \"professeur\" ou \"utilisateur\"</p>";
                            }
                        } else {
                            echo "<p class='alert alert-danger'>Erreur lors de la vérification du captcha</p>";
                        }
                    } else {
                        echo "<p class='alert alert-danger'>Le lien de l'image doit etre sous la forme \"assets/profilepicture/nomimage.png\"</p>";
                    }
                    break;
                case 'supression':
                    if ($_POST['captcha'] == $_SESSION['code']) {
                        if (supressionCompte($_POST['login'])) {
                            echo "<p class='alert alert-success'>Compte supprimé avec succès</p>";
                            afficheUsers();
                        } else {
                            echo "<p class='alert alert-danger'>Erreur lors de la supression du compte</p>";
                        }
                    } else {
                        echo "<p class='alert alert-danger'>Erreur lors de la vérification du captcha</p>";
                    }
                    break;
                case 'modification':
                    if (preg_match('/^assets\/profilepicture\/.*\.png$/', $_POST['image'])) {
                        if ($_POST['captcha'] == $_SESSION['code']) {
                            if (in_array($_POST['statut'], ['administrateur', 'professeur', 'utilisateur'])) {
                                if (modificationCompte($_POST['login'], $_POST['password'], $_POST['statut'], $_POST['image'])) {
                                    echo "<p class='alert alert-success'>Compte modifié avec succès</p>";
                                    afficheUsers();
                                } else {
                                    echo "<p class='alert alert-danger'>Erreur lors de la modification du compte</p>";
                                }

                            } else {
                                echo "<p class='alert alert-danger'>Le statut doit etre \"administateur\", \"professeur\" ou \"utilisateur\"</p>";
                            }
                        } else {
                            echo "<p class='alert alert-danger'>Erreur lors de la vérification du captcha</p>";
                        }
                    } else {
                        echo "<p class='alert alert-danger'>Le lien de l'image doit etre sous la forme \"assets/profilepicture/nomimage.png\"</p>";
                    }
                    break;
                case 'uploadImage':
                    if (preg_match('/\.png$/', $_FILES['image']['name'])) {
                        if ($_POST['captcha'] == $_SESSION['code']) {
                            if ($name = uploadImage($_FILES['image']['tmp_name'], $_FILES['image']['name'])) {
                                echo "<p class='alert alert-success'>Image uploadé avec succès sous le nom: " . $name . "</p>";
                            } else {
                                echo "<p class='alert alert-danger'>Erreur lors de l'upload de l'image</p>";
                            }
                        } else {
                            echo "<p class='alert alert-danger'>Erreur lors de la vérification du captcha</p>";
                        }
                    } else {
                        echo "<p class='alert alert-danger'>L'image doit etre au format PNG</p>";
                    }

                    echo "<div class='text-center'><a href='administration.php' class='btn btn-dark'>Retour</a></div>";
                    break;
                case 'deleteImage':
                    if ($_POST['captcha'] == $_SESSION['code']) {
                        if (deleteImage($_POST['image'])) {
                            echo "<p class='alert alert-success'>Image supprimé avec succès</p>";
                        } else {
                            echo "<p class='alert alert-danger'>Erreur lors de la supression de l'image</p>";
                        }
                    } else {
                        echo "<p class='alert alert-danger'>Erreur lors de la vérification du captcha</p>";
                    }

                    echo "<div class='text-center'><a href='administration.php' class='btn btn-dark'>Retour</a></div>";
                    break;
            }

        } else {
            formulaireChoixAdministation();
        }
        ?>
        <div id="under-footer"> </div>
    </main>

    <footer class="footer fixed-bottom bg-dark light-text">
        <p class="var_dump">
            <?php
            // var_dump();
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