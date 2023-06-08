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
    Fonction qui affiche un menu de navigation en fonction de la connexion de l'utilisateur avec bootstrap
    */
    $connexion = "<li class='nav-item'><a class='nav-link' href='connexion.php'><img src='assets/icons/connexion.svg' alt='Connexion' title='Connexion' class='icon'></a></li>";
    $index = "<li class='nav-item'><a class='nav-link' href='index.php'><img src='assets/icons/home.svg' alt='Accueil' title='Accueil' class='icon'></a></li>";
    $insertion = "<li class='nav-item'><a class='nav-link' href='insertion.php'><img src='assets/icons/plus.svg' alt='Insertion' title='Insertion' class='icon'></a></li>";
    $modification = "<li class='nav-item'><a class='nav-link' href='modification.php'><img src='assets/icons/crayon.svg' alt='Modification' title='Modification' class='icon'></a></li>";
    $supression = "<li class='nav-item'><a class='nav-link' href='supression.php'><img src='assets/icons/poubelle.svg' alt='Supression' title='Supression' class='icon'></a></li>";
    $administration = "<li class='nav-item'><a class='nav-link' href='administration.php'><img src='assets/icons/admin.svg' alt='Administration' title='Administration' class='icon'></a></li>";
    $deconnexion = "<li class='nav-item'><a class='nav-link' href='connexion.php?action=logout'><img src='assets/icons/deconnexion.svg' alt='Deconnexion' title='Deconnexion' class='icon'></a></li>";
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

# Fonction d'affichage =============================================================================

function afficheNotes($notes)
{
    // Fonction qui affiche les notes passées en paramètre 
    // Si la page est modification.php, rajouter une colonne pour la selection
    $matieres = getMatieres();
    $types = getTypeNotes();
    echo '<table class="table table-light table-striped table-hover table-bordered border-dark-subtle table-sm"><thead><tr><th>Matière</th><th>Type</th><th>Note</th><th>Coefficient</th>';
    if (strtolower(explode('.', basename($_SERVER['PHP_SELF']))[0]) == "modification") {
        echo '<th>Etudiant</th><th>Séléctioner</th>';
    }
    echo '</tr></thead><tbody class="table-group-divider">';
    foreach ($notes as $note) {
        foreach ($matieres as $matiere) {
            foreach ($types as $type) {
                if ($note['noMat'] == $matiere['NoMat']) {
                    if ($note['noNote'] == $type['NoNote']) {
                        if (strtolower(explode('.', basename($_SERVER['PHP_SELF']))[0]) == "modification") {
                            echo '<tr><td><img src="' . getMatPicture($matiere['NomMat']) . '" title="' . $matiere['NomMat'] . '" alt="' . $matiere['NomMat'] . '" class="matiere-icon"> ' . $matiere['NomMat'] . '</td><td>' . $type['NomNote'] . '</td><td>' . $note['note'] . '</td><td>' . $note['Coefficient'] . '</td><td>' . $note['login'] . '</td><td><a href="modification.php?id=' . $note['id'] . '"><img src="assets/icons/select.svg" alt="Séléctioner" class="select"></a></td></tr>';
                        } else {
                            echo '<tr><td><img src="' . getMatPicture($matiere['NomMat']) .'" title="' . $matiere['NomMat'] . '" alt="' . $matiere['NomMat'] . '" class="matiere-icon"> ' . $matiere['NomMat'] . '</td><td>' . $type['NomNote'] . '</td><td>' . $note['note'] . '</td><td>' . $note['Coefficient'] . '</td></tr>';
                        }
                    }
                }
            }
        }
    }
    echo '</tbody><tfoot class="table-group-divider"><tr><th>Matière</th><th>Type</th><th>Note</th><th>Coefficient</th>';
    if (strtolower(explode('.', basename($_SERVER['PHP_SELF']))[0]) == "modification") {
        echo '<th>Etudiant</th><th>Séléctioner</th>';
    }
    echo '</tr></tfoot></table>';
}

function afficheUsers()
{
    // Fonction qui affiche les utilisateurs de la base de données
    $user = getAllUsers();
    echo '<div class="container ">';
    echo '<table class="table table-light table-striped table-hover table-bordered border-dark-subtle table-sm"><thead><tr><th>Login</th><th>Mot de passe</th><th>Statut</th></tr></thead><tbody class="table-group-divider">';
    foreach ($user as $u) {
        echo '<tr><td>' . $u['login'] . '</td><td>' . $u['motdepasse'] . '</td><td>' . $u['statut'] . '</td></tr>';
    }
    echo '</tbody><tfoot class="table-group-divider"><tr><th>Login</th><th>Mot de passe</th><th>Statut</th></tr></tfoot></table>';
    echo "<div class='text-center'><a href='administration.php' class='btn btn-dark'>Retour</a></div>";
    echo '</div>';
}

# Fonction de recuperation =============================================================================

function getProfilePicture($etu)
{
    // Fonction qui récupère l'image de profil d'un utilisateur
    $resultat = false;
    try {
        $db = new PDO('sqlite:db/db.sqlite');
        $rq = 'SELECT profilepicture FROM Comptes WHERE (login = "' . $etu . '")';
        $resultat = $db->query($rq);
        $resultat = $resultat->fetch(PDO::FETCH_ASSOC);
        $resultat = $resultat['profilepicture'];
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $resultat;
}

function getMatPicture($matiere)
{
    // Fonction qui récupère l'image d'une matière
    $resultat = false;
    try {
        $db = new PDO('sqlite:db/db.sqlite');
        $rq = 'SELECT Image FROM Matieres WHERE (NomMat = "' . $matiere . '")';
        $resultat = $db->query($rq);
        $resultat = $resultat->fetch(PDO::FETCH_ASSOC);
        $resultat = $resultat['Image'];
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $resultat;
}

function getAllUsers()
{
    // Récupère tous les utilisateurs de la base de données
    $users = false;

    try {
        // Connection to the database
        $db = new PDO('sqlite:db/db.sqlite');
        $rq = 'SELECT * FROM Comptes';
        $resultat = $db->query($rq);
        $users = $resultat->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        echo "erreur de connection a la BDO";
    }
    return $users;
}
function getAllNotes()
{
    // Récupère toutes les notes de la base de données
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
    // Tri les notes passées en paramètre par étudiant
    $resultat = array();
    // Si le login est vide, on retourne toutes les notes
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
    // Tri les notes passées en paramètre par matière
    $resultat = array();
    // Si la matière est égal à all, on retourne toutes les notes
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
    // Tri les notes passées en paramètre par type
    $resultat = array();
    // Si le type est égal à all, on retourne toutes les notes
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
    // Récupère une note par son id
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
    // Récupère toutes les matières de la base de données
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
    // Récupère tous les types de notes de la base de données
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
    // Récupère la moyenne d'un étudiant
    $moyenne = false;
    $coefficients = 0;
    $notes = getNotesByEtu(getAllNotes(), $login);
    foreach ($notes as $note) {
        $moyenne += $note['note'] * $note['Coefficient'];
        $coefficients += $note['Coefficient'];
    }
    return round($moyenne / $coefficients, 2);
}

function getImages()
{
    // Récupère toutes les images de la base de données
    $images = scandir('assets\profilepicture\\');
    echo $images;
    return array_diff($images, array('.', '..'));
}

# Modification de la base =============================================================================

function modificationNote($id, $matiere, $type, $note, $coefficient)
{
    // Modifie une note dans la base de données
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

function ajoutCompte($login, $pass, $statut, $profilepicture)
{
    // Ajoute un compte dans la base de données
    $resultat = false;
    try {
        $db = new PDO('sqlite:db/db.sqlite');
        $rq = 'INSERT INTO Comptes (login, motdepasse, statut, profilepicture) VALUES ("' . $login . '", "' . $pass . '", "' . $statut . '", "' . $profilepicture . '")';
        $resultat = $db->exec($rq);
    } catch (Exception $e) {
        echo "erreur de connection a la BDO";
    }
    return $resultat;
}

function supressionCompte($login)
{
    // Supprime un compte dans la base de données
    $resultat = false;
    try {
        $db = new PDO('sqlite:db/db.sqlite');
        $rq = 'DELETE FROM Comptes WHERE login = "' . $login . '"';
        $resultat = $db->exec($rq);
    } catch (Exception $e) {
        echo "erreur de connection a la BDO";
    }
    return $resultat;
}

function modificationCompte($login, $pass, $statut, $profilepicture)
{
    // Modifie un compte dans la base de données
    $resultat = false;
    try {
        $db = new PDO('sqlite:db/db.sqlite');
        $rq = 'UPDATE Comptes SET motdepasse = "' . $pass . '", statut = "' . $statut . '", profilepicture = "' . $profilepicture . '" WHERE login = "' . $login . '"';
        $resultat = $db->exec($rq);
    } catch (Exception $e) {
        echo "erreur de connection a la BDO";
    }
    return $resultat;
}

# Autres fonctions =================================================================================

function uploadImage($image, $name)
{
    // Upload une image dans le dossier assets/profilepicture/
    $resultat = false;
    $dossierImage = "assets/profilepicture/";
    $target = $dossierImage . $name;
    // Tant que le nom de fichier existe deja rajouter un 1 devant
    while (file_exists($target)) {
        $name = "1" . $name;
        $target = $dossierImage . $name;
    }
    // Quand le nom est unique on deplace l'image du dossier temporaire vers assets/profilepicture/
    if (rename($image, $target)) {
        $resultat = $name;
    }
    return $resultat;
}

function deleteImage($image)
{
    // Supprime une image dans le dossier assets/profilepicture/
    $resultat = false;
    if (unlink($image)) {
        $resultat = true;
    }
    return $resultat;
}

# Fonctions de connexion ============================================================================
if (isset($_POST['email']) && isset($_POST['password'])) {
    if (authentification($_POST['email'], $_POST['password'])) {
        header('Location: index.php');
    } else {
        header('Location: connexion.php?login=error');
    }
}