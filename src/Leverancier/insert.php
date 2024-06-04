<?php
// Auteur: Amin
// Functie: Insert Leverancier

require '../../vendor/autoload.php';
use Bas\classes\Leverancier;

$message = "";

if (isset($_POST["insert"]) && $_POST["insert"] == "Toevoegen") {
    if (
        isset($_POST['leveranciernaam']) && isset($_POST['leverancieremail']) && isset($_POST['leverancieradres']) && isset($_POST['leverancierpostcode']) && isset($_POST['leverancierwoonplaats'])
    ) {

        // Maak een nieuw Leverancier object aan
        $leverancier = new Leverancier();

        // Bereid de leveranciergegevens voor
        $leveranciergegevens = [
            'levNaam' => $_POST['leveranciernaam'],
            'levEmail' => $_POST['leverancieremail'],
            'levWoonplaats' => $_POST['leverancierwoonplaats'],
            'levAdres' => $_POST['leverancieradres'],
            'levPostcode' => $_POST['leverancierpostcode']
        ];

        // Voeg de leveranciergegevens toe aan de database
        if ($leverancier->insertLeverancier($leveranciergegevens)) {
            $message = "Leverancier succesvol toegevoegd!";
        } else {
            $message = "Er is een fout opgetreden bij het toevoegen van de leverancier.";
        }
    } else {
        $message = "Vul alstublieft alle vereiste velden in.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toevoegen Leverancier</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <h1>CRUD Leverancier</h1>
    <h2>Toevoegen</h2>
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="leveranciernaam">Leveranciernaam:</label>
        <input type="text" id="leveranciernaam" name="leveranciernaam" placeholder="Leveranciernaam" required/>
        <br>
        <label for="leverancieremail">Leverancieremail:</label>
        <input type="email" id="leverancieremail" name="leverancieremail" placeholder="Leverancieremail" required/>
        <br>
        <label for="leverancierwoonplaats">Leverancier Woonplaats:</label>
        <input type="text" id="leverancierwoonplaats" name="leverancierwoonplaats" placeholder="Leverancier Woonplaats" required/>
        <br>
        <label for="leverancierpostcode">Leverancier Postcode:</label>
        <input type="text" id="leverancierpostcode" name="leverancierpostcode" placeholder="Leverancier Postcode" required/>
        <br>
        <label for="leverancieradres">Leverancier Adres:</label>
        <input type="text" id="leverancieradres" name="leverancieradres" placeholder="Leverancier Adres" required/>
        <br><br>
        <input type='submit' name='insert' value='Toevoegen'>
    </form></br>

    <a href='read.php'>Terug</a>

</body>
</html>
