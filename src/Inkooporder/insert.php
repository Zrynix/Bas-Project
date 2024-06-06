<?php
// Auteur: Amin
// Functie: Insert

require '../../vendor/autoload.php';
use Bas\classes\Leverancier;
use Bas\classes\Artikel;
use Bas\classes\Inkooporder;

$message = "";

if (isset($_POST["insert"]) && $_POST["insert"] == "Toevoegen") {
    if (
        isset($_POST['levNaam']) && isset($_POST['levEmail']) && isset($_POST['levAdres']) && isset($_POST['levPostcode']) &&
        isset($_POST['levWoonplaats']) && isset($_POST['artikelnaam']) && isset($_POST['artikelprijs']) && isset($_POST['inkOrdDatum']) &&
        isset($_POST['inkOrdBestAantal']) && isset($_POST['inkOrdStatus'])
    ) {
        $levNaam = $_POST['levNaam'];
        $levEmail = $_POST['levEmail'];
        $levWoonplaats = $_POST['levWoonplaats'];
        $levAdres = $_POST['levAdres'];
        $levPostcode = $_POST['levPostcode'];
        $artikelnaam = $_POST['artikelnaam'];
        $artikelprijs = $_POST['artikelprijs'];
        $inkOrdDatum = $_POST['inkOrdDatum'];
        $inkOrdBestAantal = $_POST['inkOrdBestAantal'];
        $inkOrdStatus = $_POST['inkOrdStatus'];

        $leverancier = new Leverancier();
        $artikel = new Artikel();
        $inkooporder = new Inkooporder();

        $leveranciergegevens = [
            'levNaam' => $levNaam,
            'levEmail' => $levEmail,
            'levWoonplaats' => $levWoonplaats,
            'levAdres' => $levAdres,
            'levPostcode' => $levPostcode
        ];

        $artikelgegevens = [
            'artikelNaam' => $artikelnaam,
            'artikelPrijs' => $artikelprijs
        ];

        if ($leverancier->insertLeverancier($leveranciergegevens)) {
            $leverancierId = $leverancier->getLastInsertedId();

            if ($artikel->insertArtikel($artikelgegevens)) {
                $artikelId = $artikel->getLastInsertedId();

                $inkoopordergegevens = [
                    'levId' => $leverancierId,
                    'artId' => $artikelId,
                    'inkOrdDatum' => $inkOrdDatum,
                    'inkOrdBestAantal' => $inkOrdBestAantal,
                    'inkOrdStatus' => $inkOrdStatus
                ];
                if ($inkooporder->insertInkooporder($inkoopordergegevens)) {
                    $message = "Inkooporder succesvol toegevoegd!";
                } else {
                    $message = "Er is een fout opgetreden bij het toevoegen van de inkooporder.";
                }
            } else {
                $message = "Er is een fout opgetreden bij het toevoegen van het artikel.";
            }
        } else {
            $message = "Er is een fout opgetreden bij het toevoegen van de leverancier.";
        }
    } else {
        $message = "Vul alstublieft alle vereiste velden in.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toevoegen Leverancier en Artikel</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <h1>CRUD Inkooporder</h1>
    <h2>Toevoegen</h2>
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="levNaam">Leveranciernaam:</label>
        <input type="text" id="levNaam" name="levNaam" placeholder="Leveranciernaam" required/>
        <br>
        <label for="levEmail">Leverancieremail:</label>
        <input type="email" id="levEmail" name="levEmail" placeholder="Leverancieremail" required/>
        <br>
        <label for="levWoonplaats">Leverancier Woonplaats:</label>
        <input type="text" id="levWoonplaats" name="levWoonplaats" placeholder="Leverancier Woonplaats" required/>
        <br>
        <label for="levPostcode">Leverancier Postcode:</label>
        <input type="text" id="levPostcode" name="levPostcode" placeholder="Leverancier Postcode" required/>
        <br>
        <label for="levAdres">Leverancier Adres:</label>
        <input type="text" id="levAdres" name="levAdres" placeholder="Leverancier Adres" required/>
        <br>
        <label for="artikelnaam">Artikelnaam:</label>
        <input type="text" id="artikelnaam" name="artikelnaam" placeholder="Artikelnaam" required/>
        <br>
        <label for="artikelprijs">Artikelprijs:</label>
        <input type="text" id="artikelprijs" name="artikelprijs" placeholder="Artikelprijs" required/>
        <br>
        <label for="inkOrdDatum">Inkooporder Datum:</label>
        <input type="date" id="inkOrdDatum" name="inkOrdDatum" placeholder="Inkooporder Datum" required/>
        <br>
        <label for="inkOrdBestAantal">Inkooporder Bestel Aantal:</label>
        <input type="number" id="inkOrdBestAantal" name="inkOrdBestAantal" placeholder="Inkooporder Bestel Aantal" required/>
        <br>
        <label for="inkOrdStatus">Inkooporder Status:</label>
        <input type="text" id="inkOrdStatus" name="inkOrdStatus" placeholder="Inkooporder Status" required/>
        <br>
        <input type="submit" name="insert" value="Toevoegen"/>
    </form>

    <a href='../index.php'>Terug naar het hoofdmenu</a>

</body>
</html>
