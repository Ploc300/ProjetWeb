<?php
header("Content-Security-Policy: default-src 'self'");
function FormulaireModification($id)
{
    // Affiche le formulaire de modification d'une note
    $note = getNoteById($id);
    echo "<input type='hidden' name='id_modif' value='" . $id . "'>";
    echo "<div class='form-group'>";
    echo "<input type='email' readonly class='form-control' value='" . $note['login'] . "' name='login_modif' id='login_modif' placeholder='Login'>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<select class='form-control' name='matiere_modif' id='matiere_modif'>";
    foreach (getMatieres() as $matiere) {
        if ($matiere['NoMat'] == $note['noMat']) {
            echo "<option value='" . $matiere['NoMat'] . "' selected>" . $matiere['NomMat'] . "</option>";
        } else {
            echo "<option value='" . $matiere['NoMat'] . "'>" . $matiere['NomMat'] . "</option>";
        }
    }
    echo "</select>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<select class='form-control' name='type_modif' id='type_modif'>";
    foreach (getTypeNotes() as $type) {
        if ($type['NoNote'] == $note['noNote']) {
            echo "<option value='" . $type['NoNote'] . "' selected>" . $type['NomNote'] . "</option>";
        } else {
            echo "<option value='" . $type['NoNote'] . "'>" . $type['NomNote'] . "</option>";
        }
    }
    echo "</select>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<input type='number' class='form-control' value='" . $note['note'] . "' name='note' id='note' placeholder='Note' min='0' max='20'>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<input type='number' class='form-control' value='" . $note['Coefficient'] . "' name='coeff' id='coeff' placeholder='Coefficient' min='0' max='5'>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo '<input class=\'form-control\' placeholder="Captcha" type="text" name="captcha">';
    echo '<span class="card ">';
    echo '<img src="image.php" onclick="this.src=\'image.php?\' + Math.random();" alt="captcha" style="cursor:pointer;">';
    echo '</span>';
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<button type='submit' class='btn btn-dark'>Modifier</button>";
    echo "</div>";


}

function formulaireChoixAdministation()
{
    // Affiche le formulaire de choix de la page administration
    echo "<div class='d-flex justify-content-center text-center'>";
    echo "<form action='administration.php' method='get'>";
    echo "<div class='form-group'>";
    echo "<a href='administration.php?action=ajout' class='btn btn-dark'>Ajouter un utilisateur</a>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<a href='administration.php?action=modification' class='btn btn-dark'>Modifier un utilisateur</a>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<a href='administration.php?action=supression' class='btn btn-dark'>Supprimer un utilisateur</a>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<a href='administration.php?action=afficher' class='btn btn-dark'>Afficher la liste des utilisateurs</a>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<a href='administration.php?action=uploadImage' class='btn btn-dark'>Uploader une image</a>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<a href='administration.php?action=deleteImage' class='btn btn-dark'>Supprimer une image</a>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<a href='administration.php?action=afficherLogs' class='btn btn-dark'>Afficher les logs</a>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
}

function formulaireAjoutAdmin()
{
    // Affiche le formulaire d'ajout d'un utilisateur
    echo "<div class='d-flex justify-content-center text-center'>";
    echo "<form action='administration.php' method='post'>";
    echo "<div class='form-group'>";
    echo "<input type='email' required class='form-control' name='login' id='login' placeholder='Login'>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<input type='password' required class='form-control' name='password' id='password' placeholder='Mot de passe'>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<select class='form-control' name='statut' id='statut'>";
    echo "<option value='administrateur'>Administrateur</option>";
    echo "<option value='professeur'>Professeur</option>";
    echo "<option value='utilisateur' selected>Utilisateur</option>";
    echo "</select>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<select class='form-control' name='image' id='image'>";
    foreach (getImages() as $useless => $image) {
        echo "<option value='assets/profilepicture/" . $image . "'>" . $image . "</option>";
    }
    echo "</select>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo '<input class=\'form-control\' placeholder="Captcha" type="text" name="captcha">';
    echo '<span class="card ">';
    echo '<img src="image.php" onclick="this.src=\'image.php?\' + Math.random();" alt="captcha" style="cursor:pointer;">';
    echo '</span>';
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<button type='submit' name='action' value='ajout' class='btn btn-dark'>Ajouter</button>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
}

function formulaireSupressionAdmin()
{
    // Affiche le formulaire de supression d'un utilisateur
    echo "<div class='d-flex justify-content-center text-center'>";
    echo "<form action='administration.php' method='post'>";
    echo "<div class='form-group'>";
    echo "<select class='form-control' name='login' id='login'>";
    foreach (getAllUsers() as $user) {
        echo "<option value='" . $user['login'] . "'>" . $user['login'] . "</option>";
    }
    echo "</select>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo '<input class=\'form-control\' required placeholder="Captcha" type="text" name="captcha">';
    echo '<span class="card ">';
    echo '<img src="image.php" onclick="this.src=\'image.php?\' + Math.random();" alt="captcha" style="cursor:pointer;">';
    echo '</span>';
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<button type='submit' name='action' value='supression' class='btn btn-dark'>Supprimer</button>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
}

function formulaireModificationAdmin()
{
    // Affiche le formulaire de modification d'un utilisateur
    echo "<div class='d-flex justify-content-center text-center'>";
    echo "<form action='administration.php' method='post'>";
    echo "<div class='form-group'>";
    echo "<select class='form-control' name='login' id='login'>";
    foreach (getAllUsers() as $user) {
        echo "<option value='" . $user['login'] . "'>" . $user['login'] . "</option>";
    }
    echo "</select>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<input type='password' class='form-control' name='password' id='password' placeholder='Mot de passe'>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<select class='form-control' name='statut' id='statut'>";
    echo "<option value='administrateur'>Administrateur</option>";
    echo "<option value='professeur'>Professeur</option>";
    echo "<option value='utilisateur' selected>Utilisateur</option>";
    echo "</select>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<select class='form-control' name='image' id='image'>";
    foreach (getImages() as $_ => $image) {
        echo "<option value='assets/profilepicture/" . $image . "'>" . $image . "</option>";
    }
    echo "</select>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo '<input class=\'form-control\' required placeholder="Captcha" type="text" name="captcha">';
    echo '<span class="card ">';
    echo '<img src="image.php" onclick="this.src=\'image.php?\' + Math.random();" alt="captcha" style="cursor:pointer;">';
    echo '</span>';
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<button type='submit' name='action' value='modification' class='btn btn-dark'>Modifier</button>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
}

function formulaireUploadImage()
{
    // Affiche le formulaire d'ajout d'une image
    echo "<div class='d-flex justify-content-center text-center'>";
    echo "<form action='administration.php' method='post' enctype='multipart/form-data'>";
    echo "<p>Uploader une image</p>";
    echo "<div class='form-group'>";
    echo "<input required accept='.png' type='file' class='form-control' name='image' id='image'>";
    echo "<div id='imageHelp' class='form-text'>Seul les fichiers .png sont acceptés (max: 10Mb)</div>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo '<input class=\'form-control\' required placeholder="Captcha" type="text" name="captcha">';
    echo '<span class="card ">';
    echo '<img src="image.php" onclick="this.src=\'image.php?\' + Math.random();" alt="captcha" style="cursor:pointer;">';
    echo '</span>';
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<button type='submit' name='action' value='uploadImage' class='btn btn-dark'>Uploader</button>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
}

function formulaireDeleteImage()
{
    // Affiche le formulaire de supression d'une image
    echo "<div class='d-flex justify-content-center text-center'>";
    echo "<form action='administration.php' method='post'>";
    echo "<p>Supprimer une image</p>";
    echo "<div class='form-group'>";
    echo "<select class='form-control' name='image' id='image'>";
    foreach (getImages() as $_ => $image) {
        echo "<option value='assets/profilepicture/" . $image . "'>" . $image . "</option>";
    }
    echo "</select>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo '<input class=\'form-control\' required placeholder="Captcha" type="text" name="captcha">';
    echo '<span class="card ">';
    echo '<img src="image.php" onclick="this.src=\'image.php?\' + Math.random();" alt="captcha" style="cursor:pointer;">';
    echo '</span>';
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<button type='submit' name='action' value='deleteImage' class='btn btn-dark'>Supprimer</button>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
}

?>