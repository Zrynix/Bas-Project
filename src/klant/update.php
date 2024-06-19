<?php
// Auteur: Amin
// Functie: Update Klant

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\Klant;

$klant = new Klant();

if (isset($_POST["update"]) && $_POST["update"] == "Wijzigen") {
    $data = [
        'klantId' => $_POST['klantId'],
        'klantNaam' => $_POST['klantNaam'],
        'klantEmail' => $_POST['klantEmail'],
        'klantWoonplaats' => $_POST['klantWoonplaats'],
        'klantAdres' => $_POST['klantAdres'],
        'klantPostcode' => $_POST['klantPostcode']
    ];
    if ($klant->updateKlant($data)) {
        header("Location: read.php");
        exit;
    } else {
        echo "Er is een fout opgetreden bij het bijwerken van de klant.";
    }
}

if (isset($_GET['klantId'])) {
    $row = $klant->getKlant((int)$_GET['klantId']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Klant</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<h1>CRUD Klant</h1>
<h2>Wijzigen</h2>    
<form method="post">
    <input type="hidden" name="klantId" value="<?php if (isset($row)) { echo $row['klantId']; } ?>">
    <label for="klantNaam">Naam:</label>
    <input type="text" name="klantNaam" required value="<?php if (isset($row)) { echo $row['klantNaam']; } ?>"> *</br>
    <label for="klantEmail">Email:</label>
    <input type="email" name="klantEmail" required value="<?php if (isset($row)) { echo $row['klantEmail']; } ?>"> *</br>
    <label for="klantWoonplaats">Woonplaats:</label>
    <input type="text" name="klantWoonplaats" required value="<?php if (isset($row)) { echo $row['klantWoonplaats']; } ?>"> *</br>
    <label for="klantAdres">Adres:</label>
    <input type="text" name="klantAdres" required value="<?php if (isset($row)) { echo $row['klantAdres']; } ?>"> *</br>
    <label for="klantPostcode">Postcode:</label>
    <input type="text" name="klantPostcode" required value="<?php if (isset($row)) { echo $row['klantPostcode']; } ?>"> *</br></br>
    <input type="submit" name="update" value="Wijzigen">
</form></br>

<a href="read.php">Terug</a>

</body>
</html>

<?php
} else {
    echo "Geen klantId opgegeven<br>";
}
?>
