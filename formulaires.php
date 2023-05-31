<?php
function FormulaireModification($id)
{
    $note = getNoteById($id);
    echo "<input type='hidden' name='id' value='" . $id . "'>";
    echo "<div class='form-group'>";
    echo "<input type='email' readonly class='form-control' value='" . $note['login'] . "' name='login' id='login' placeholder='Login'>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<select class='form-control' name='matiere' id='matiere'>";
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
    echo "<select class='form-control' name='type' id='type'>";
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
    echo "<input type='text' class='form-control' value='" . $note['note'] . "' name='note' id='note' placeholder='Note' min='0' max='20'>";
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<input type='text' class='form-control' value='" . $note['Coefficient'] . "' name='coeff' id='coeff' placeholder='Coefficient' min='0' max='5'>";
    echo "</div class='form-group'>";
    echo "<div class='form-group'>";
    echo '<input class=\'form-control\' type="text" name="captcha" />';
    echo '<img src="image.php" onclick="this.src=\'image.php?\' + Math.random();" alt="captcha" style="cursor:pointer;">';
    echo "</div>";
    echo "<div class='form-group'>";
    echo "<button type='submit' class='btn btn-dark'>Modifier</button>";
    echo "</div>";


}




























?>