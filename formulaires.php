<?php
function FormulaireModification($id)
{
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
    echo '<img src="image.php" onclick="this.src=\'image.php?\' + Math.random();" alt="captcha" style="cursor:pointer;">';
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<button type='submit' class='btn btn-dark'>Modifier</button>";
    echo "</div>";


}

function formulaireChoixAdministation()
{
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
    echo "</form>";
    echo "</div>";
}

function formulaireAjoutAdmin()
{
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
    echo "</div>";
    echo "<div class='form-group'>";
    echo '<input type="text" required class="form-control" value="assets/profilepicture/" placeholder="profilepicture" name="profilepicture" id="profilepicture">';
    echo "</div>";
    echo "<div class='form-group'>";
    echo '<input class=\'form-control\' required placeholder="Captcha" type="text" name="captcha">';
    echo '<img src="image.php" onclick="this.src=\'image.php?\' + Math.random();" alt="captcha" style="cursor:pointer;">';
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<button type='submit' name='action' value='ajout' class='btn btn-dark'>Ajouter</button>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
}

function formulaireSupressionAdmin()
{
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
    echo '<img src="image.php" onclick="this.src=\'image.php?\' + Math.random();" alt="captcha" style="cursor:pointer;">';
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<button type='submit' name='action' value='supression' class='btn btn-dark'>Supprimer</button>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
}

function formulaireModificationAdmin() {
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
    echo "</div>";
    echo "<div class='form-group'>";
    echo '<input class=\'form-control\' required placeholder="Captcha" type="text" name="captcha">';
    echo '<img src="image.php" onclick="this.src=\'image.php?\' + Math.random();" alt="captcha" style="cursor:pointer;">';
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<button type='submit' name='action' value='modification' class='btn btn-dark'>Modifier</button>";
    echo "</div>";
    echo "</form>";
    echo "</div>";
}


























?>