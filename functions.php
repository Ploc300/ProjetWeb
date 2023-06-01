<?php

# Fonction de redirection =============================================================================

function noSessionRedirect()
{
    /*
    Fonction qui redirige vers la page de connexion si l'utilisateur n'est pas connecté
    */
    if (!isset($_SESSION['uRole'])) {
        header('Location: connexion.php');
    }
}

function noProfRedirect()
{
    /*
    Fonction qui redirige vers la page d'accueil si l'utilisateur n'est pas professeur
    */
    if ($_SESSION['uRole'] != "professeur" && $_SESSION['uRole'] != "administrateur") {
        header('Location: index.php');
    }
}

function noAdminRedirect()
{
    /*
    Fonction qui redirige vers la page d'accueil si l'utilisateur n'est pas administrateur
    */
    if ($_SESSION['uRole'] != "administrateur") {
        header('Location: index.php');
    }
}

# Fonction de menu =============================================================================

function menu()
{
    /*
    Fonction qui affiche un menu de navigation en fonction de la connexion de l'utilisateur
    Style: Boostrap 5
    */
    $connexion = "<li class='nav-item'><a class='nav-link' href='connexion.php'><img src='assets/icons/connexion.png' alt='Connexion' class='icon'></a></li>";
    $index = "<li class='nav-item'><a class='nav-link' href='index.php'><img src='assets/icons/home.png' alt='Accueil' class='icon'></a></li>";
    $insertion = "<li class='nav-item'><a class='nav-link' href='insertion.php'><img src='assets/icons/plus.png' alt='Insertion' class='icon'></a></li>";
    $modification = "<li class='nav-item'><a class='nav-link' href='modification.php'><img src='assets/icons/crayon.png' alt='Modification' class='icon'></a></li>";
    $supression = "<li class='nav-item'><a class='nav-link' href='supression.php'><img src='assets/icons/poubelle.png' alt='Supression' class='icon'></a></li>";
    $administration = "<li class='nav-item'><a class='nav-link' href='administration.php'><img src='assets/icons/cle.png' alt='Addministration' class='icon'></a></li>";
    $deconnexion = "<li class='nav-item'><a class='nav-link' href='connexion.php?action=logout'><img src='assets/icons/deconnexion.png' alt='Deconnexion' class='icon'></a></li>";
    if (!isset($_SESSION['uRole'])) {
        echo $connexion;
    } else if ($_SESSION['uRole'] == "administrateur") {
        echo $connexion;
        echo $index;
        echo $insertion;
        echo $modification;
        echo $supression;
        echo $administration;
        echo $deconnexion;
    } else if ($_SESSION['uRole'] == "professeur") {
        echo $connexion;
        echo $index;
        echo $insertion;
        echo $modification;
        echo $supression;
        echo $deconnexion;
    } else if ($_SESSION['uRole'] == "utilisateur") {
        echo $connexion;
        echo $index;
        echo $deconnexion;
    }
}

function getProfilePicture($etu) {
    $db = new PDO('sqlite:db/db.sqlite');
    $rq = 'SELECT profilepicture FROM Comptes WHERE (login = "' . $etu . '")';
    $resultat = $db->query($rq);
    $resultat = $resultat->fetch(PDO::FETCH_ASSOC);
    return $resultat['profilepicture'];
}

function connexion()
{
    echo '<div class="form-container">
            <form action="functions.php" method="post">
                <div class="form-group d-flex flex-column align-items-center">
                    <label for="email">Adresse email</label>
                    <input required placeholder="@iut.fr" type="email" class="form-control" id="email" name="email"
                        aria-describedby="emailHelp">
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
        </div>';
}

# Fonction d'authentification =============================================================================

function authentification($login, $pass)
{
    /*
    Fonction qui vérifie si le login et le mot de passe sont corrects
    et attribue un role à l'utilisateur
    */
    $retour = false;
    try {
        session_start();
        // Connection to the database
        $db = new PDO('sqlite:db/db.sqlite');
        $rq = 'SELECT * FROM Comptes WHERE (login = "' . $login . '") and (motdepasse = "' . $pass . '")';
        $resultat = $db->query($rq);
        $etu = $resultat->fetch(PDO::FETCH_ASSOC);

        // Check if the user/password combination is correct
        if (isset($etu)) {
            if ($etu['login'] == $login && $etu['motdepasse'] == $pass) {

                // Set up the session
                $_SESSION['uLogin'] = $login;
                $_SESSION['uRole'] = $etu['statut'];

                // Log the succesfull connection
                $file = fopen('logs/success.log', 'a+');
                fputs($file, $login . " de " . $_SERVER['REMOTE_ADDR'] . " à " . date('l jS \of F Y h:i:s A'));
                fputs($file, "\n");
                fclose($file);
                $retour = true;
            } else {
                // Log the failed connection
                $file = fopen('logs/failed.log', 'a+');
                fputs($file, $login . " de " . $_SERVER['REMOTE_ADDR'] . " à " . date('l jS \of F Y h:i:s A'));
                fputs($file, "\n");
                fclose($file);
            }
        }
    } catch (Exception $e) {
        echo "erreur de connection a la BDO";
    }
    return $retour;
}

# Fonction d'affichage des notes =============================================================================

function afficheNotes($notes)
{
    $matieres = getMatieres();
    $types = getTypeNotes();
    echo '<table class="table table-light table-striped table-hover table-bordered border-dark-subtle table-sm"><thead><tr><th>Matière</th><th>Type</th><th>Note</th><th>Coefficient</th>';
    if (strtolower(explode('.', basename($_SERVER['PHP_SELF']))[0]) == "modification") {
        echo '<th>Séléctioner</th>';
    }
    echo '</tr></thead><tbody class="table-group-divider">';
    foreach ($notes as $note) {
        foreach ($matieres as $matiere) {
            foreach ($types as $type) {
                if ($note['noMat'] == $matiere['NoMat']) {
                    if ($note['noNote'] == $type['NoNote']) {
                        if (strtolower(explode('.', basename($_SERVER['PHP_SELF']))[0]) == "modification") {
                            echo '<tr><td>' . $matiere['NomMat'] . '</td><td>' . $type['NomNote'] . '</td><td>' . $note['note'] . '</td><td>' . $note['Coefficient'] . '</td><td><a href="modification.php?id=' . $note['id'] . '"><img src="assets/icons/select.png" alt="Séléctioner" class="select"></a></td></tr>';
                        } else {
                            echo '<tr><td>' . $matiere['NomMat'] . '</td><td>' . $type['NomNote'] . '</td><td>' . $note['note'] . '</td><td>' . $note['Coefficient'] . '</td></tr>';
                        }
                    }
                }
            }
        }
    }
    echo '</tbody><tfoot class="table-group-divider"><tr><th>Matière</th><th>Type</th><th>Note</th><th>Coefficient</th>';
    if (strtolower(explode('.', basename($_SERVER['PHP_SELF']))[0]) == "modification") {
        echo '<th>Séléctioner</th>';
    }
    echo '</tr></tfoot></table>';
}

# Fonction de recuperation des notes =============================================================================

function getAllNotes()
{
    $notes = false;

    try {
        // Connection to the database
        $db = new PDO('sqlite:db/db.sqlite');
        $rq = 'SELECT * FROM NotesMatieres';
        $resultat = $db->query($rq);
        $notes = $resultat->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "erreur de connection a la BDO";
    }
    return $notes;
}

function getNotesByEtu($notes, $login)
{
    $resultat = array();
    if ($login == "") {
        $resultat = $notes;
    } else {
        foreach ($notes as $note) {
            if ($note['login'] == $login) {
                array_push($resultat, $note);
            }
        }
    }
    return $resultat;
}

function getNotesByMat($notes, $matiere)
{

    $resultat = array();
    if ($matiere == "all") {
        $resultat = $notes;
    } else {
        foreach ($notes as $note) {
            if ($note['noMat'] == $matiere) {
                array_push($resultat, $note);
            }
        }
    }
    return $resultat;
}



function getNotesByType($notes, $type)
{
    $resultat = array();
    if ($type == "all") {
        $resultat = $notes;
    } else {
        foreach ($notes as $note) {
            if ($note['noNote'] == $type) {
                array_push($resultat, $note);
            }
        }
    }
    return $resultat;
}

function getNoteById($id)
{
    $note = false;
    try {
        // Connection to the database
        $db = new PDO('sqlite:db/db.sqlite');
        $rq = 'SELECT * FROM NotesMatieres WHERE id = ' . $id;
        $resultat = $db->query($rq);
        $note = $resultat->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "erreur de connection a la BDO";
    }
    return $note;
}

function getMatieres()
{
    $matieres = false;
    try {
        // Connection to the database
        $db = new PDO('sqlite:db/db.sqlite');
        $rq = 'SELECT noMat, nomMat FROM Matieres';
        $resultat = $db->query($rq);
        $matieres = $resultat->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "erreur de connection a la BDO";
    }
    return $matieres;
}

function getTypeNotes()
{
    $type = false;
    try {
        // Connection to the database
        $db = new PDO('sqlite:db/db.sqlite');
        $rq = 'SELECT noNote, nomNote FROM Notes';
        $resultat = $db->query($rq);
        $type = $resultat->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "erreur de connection a la BDO";
    }
    return $type;
}

function getMoyenneByEtu($login)
{
    $moyenne = false;
    $coefficients = 0;
    $notes = getNotesByEtu(getAllNotes(), $login);
    foreach ($notes as $note) {
        $moyenne += $note['note'] * $note['Coefficient'];
        $coefficients += $note['Coefficient'];
    }
    return round($moyenne / $coefficients, 2);
}

# Modification de la base =============================================================================

function modificationNote($id, $matiere, $type, $note, $coefficient)
{
    $resultat = false;
    try {
        $db = new PDO('sqlite:db/db.sqlite');
        $rq = 'UPDATE NotesMatieres SET noMat = ' . $matiere . ', noNote = ' . $type . ', note = ' . $note . ', Coefficient = ' . $coefficient . ' WHERE id = ' . $id;
        $resultat = $db->exec($rq);
    } catch (Exception $e) {
        echo "erreur de connection a la BDO";
    }
    return $resultat;
}

















if (isset($_POST['email']) && isset($_POST['password'])) {
    if (authentification($_POST['email'], $_POST['password'])) {
        header('Location: index.php');
    } else {
        header('Location: connexion.php?login=error');
    }
}