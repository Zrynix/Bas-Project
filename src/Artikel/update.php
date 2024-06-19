<?php
// auteur: Amin
// functie: update class Artikel

// Autoloader classes via composer
require '../../vendor/autoload.php';
use Bas\classes\Artikel;

$artikel = new Artikel;

if (isset($_POST["update"]) && $_POST["update"] == "Wijzigen") {
    $data = [
        'artId' => $_POST['artId'],
        'artOmschrijving' => $_POST['artOmschrijving'],
        'artInkoop' => $_POST['artInkoop'],
        'artVerkoop' => $_POST['artVerkoop'],
        'artVoorraad' => $_POST['artVoorraad'],
        'artMinVoorraad' => $_POST['artMinVoorraad'],
        'artMaxVoorraad' => $_POST['artMaxVoorraad'],
        'artLocatie' => $_POST['artLocatie']
    ];
    if ($artikel->updateArtikel($data)) {
        header("Location: read.php");
        exit;
    } else {
        echo "Er is een fout opgetreden bij het bijwerken van het artikel.";
    }
}

if (isset($_GET['artId'])) {
    $row = $artikel->getArtikel((int)$_GET['artId']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Artikel</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
<h1>CRUD Artikel</h1>
<h2>Wijzigen</h2>
<form method="post">
    <input type="hidden" name="artId" value="<?php if (isset($row)) { echo $row['artId']; } ?>">
    <label for="artOmschrijving">Omschrijving:</label>
    <input type="text" name="artOmschrijving" required value="<?php if (isset($row)) { echo $row['artOmschrijving']; } ?>"> *</br>
    <label for="artInkoop">Inkoop:</label>
    <input type="text" name="artInkoop" required value="<?php if (isset($row)) { echo $row['artInkoop']; } ?>"> *</br>
    <label for="artVerkoop">Verkoop:</label>
    <input type="text" name="artVerkoop" required value="<?php if (isset($row)) { echo $row['artVerkoop']; } ?>"> *</br>
    <label for="artVoorraad">Voorraad:</label>
    <input type="text" name="artVoorraad" required value="<?php if (isset($row)) { echo $row['artVoorraad']; } ?>"> *</br>
    <label for="artMinVoorraad">Min Voorraad:</label>
    <input type="text" name="artMinVoorraad" required value="<?php if (isset($row)) { echo $row['artMinVoorraad']; } ?>"> *</br>
    <label for="artMaxVoorraad">Max Voorraad:</label>
    <input type="text" name="artMaxVoorraad" required value="<?php if (isset($row)) { echo $row['artMaxVoorraad']; } ?>"> *</br>
    <label for="artLocatie">Locatie:</label>
    <input type="text" name="artLocatie" required value="<?php if (isset($row)) { echo $row['artLocatie']; } ?>"> *</br></br>
    <input type="submit" name="update" value="Wijzigen">
</form></br>

<a href="read.php">Terug</a>

</body>
</html>

<?php
} else {
    echo "Geen artId opgegeven<br>";
}
?>
