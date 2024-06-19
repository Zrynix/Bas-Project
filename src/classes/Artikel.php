<?php
// auteur: Amin
// functie: Class Artikel
namespace Bas\classes;

use Bas\classes\Database;

include_once "functions.php";

class Artikel extends Database {
    public $artId;
    public $artOmschrijving;
    public $artInkoop;
    public $artVerkoop;
    public $artVoorraad;
    public $artMinVoorraad;
    public $artMaxVoorraad;
    public $artLocatie;
    private $table_name = "Artikel";

    // Methods

    public function crudArtikel() : void {
        // Haal alle artikelen op uit de database mbv de method getArtikelen()
        $lijst = $this->getArtikelen();

        // Print een HTML tabel van de lijst    
        $this->showTable($lijst);
    }

    public function getArtikelen() : array {
        $sql = "SELECT artId, artOmschrijving, artInkoop, artVerkoop, artVoorraad, artMinVoorraad, artMaxVoorraad, artLocatie FROM " . $this->table_name;
        $stmt = self::$conn->query($sql);
        $lijst = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $lijst;
    }

    public function getArtikel(int $artId) : array {
        $sql = "SELECT artId, artOmschrijving, artInkoop, artVerkoop, artVoorraad, artMinVoorraad, artMaxVoorraad, artLocatie FROM " . $this->table_name . " WHERE artId = :artId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':artId', $artId, \PDO::PARAM_INT);
        $stmt->execute();
        $artikel = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $artikel ? $artikel : [];
    }

    public function dropDownArtikel($row_selected = -1) {
        $lijst = $this->getArtikelen();
        
        echo "<label for='Artikel'>Choose an artikel:</label>";
        echo "<select name='artId'>";
        foreach ($lijst as $row) {
            if ($row_selected == $row["artId"]) {
                echo "<option value='{$row["artId"]}' selected='selected'> {$row["artOmschrijving"]}</option>\n";
            } else {
                echo "<option value='{$row["artId"]}'> {$row["artOmschrijving"]}</option>\n";
            }
        }
        echo "</select>";
    }

    public function showTable(array $lijst) : void {
        $txt = "<table>";
        $header = array_keys($lijst[0]);
        unset($header[0]); // 
        $txt .= "<tr>";
        foreach ($header as $col) {
            $txt .= "<th>" . htmlspecialchars($col) . "</th>";
        }
        foreach ($lijst as $row) {
            $txt .= "<tr>";
            foreach (array_slice($row, 1) as $key => $value) {
                $txt .= "<td>" . htmlspecialchars($value) . "</td>";
            }
            $txt .=  "<td>
            <form method='post' action='update.php?artId={$row["artId"]}' >       
                <button name='update'>Wzg</button>    
            </form> </td>";
            $txt .=  "<td>
            <form method='post' action='delete.php?artId={$row["artId"]}' >       
                <button name='verwijderen'>Verwijderen</button>     
            </form> </td>";    
            $txt .= "</tr>";
        }
        $txt .= "</table>";
        echo $txt;
    }

    public function deleteArtikel(int $artId) : bool {
        $sql = "DELETE FROM " . $this->table_name . " WHERE artId = :artId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':artId', $artId, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateArtikel(array $data) : bool {
        $sql = "UPDATE " . $this->table_name . " 
                SET artOmschrijving = :artOmschrijving, 
                    artInkoop = :artInkoop,
                    artVerkoop = :artVerkoop,
                    artVoorraad = :artVoorraad,
                    artMinVoorraad = :artMinVoorraad,
                    artMaxVoorraad = :artMaxVoorraad,
                    artLocatie = :artLocatie
                WHERE artId = :artId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':artId', $data['artId'], \PDO::PARAM_INT);
        $stmt->bindParam(':artOmschrijving', $data['artOmschrijving'], \PDO::PARAM_STR);
        $stmt->bindParam(':artInkoop', $data['artInkoop'], \PDO::PARAM_STR);
        $stmt->bindParam(':artVerkoop', $data['artVerkoop'], \PDO::PARAM_STR);
        $stmt->bindParam(':artVoorraad', $data['artVoorraad'], \PDO::PARAM_INT);
        $stmt->bindParam(':artMinVoorraad', $data['artMinVoorraad'], \PDO::PARAM_INT);
        $stmt->bindParam(':artMaxVoorraad', $data['artMaxVoorraad'], \PDO::PARAM_INT);
        $stmt->bindParam(':artLocatie', $data['artLocatie'], \PDO::PARAM_STR);
        return $stmt->execute();
    }

    private function BepMaxArtId() : int {
        $sql = "SELECT MAX(artId)+1 FROM " . $this->table_name;
        return (int) self::$conn->query($sql)->fetchColumn();
    }

    public function insertArtikel(array $row) : bool {
        $artId = $this->BepMaxArtId();
        $sql = "INSERT INTO " . $this->table_name . " (artId, artOmschrijving, artInkoop, artVerkoop, artVoorraad, artMinVoorraad, artMaxVoorraad, artLocatie) VALUES (:artId, :artOmschrijving, :artInkoop, :artVerkoop, :artVoorraad, :artMinVoorraad, :artMaxVoorraad, :artLocatie)";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':artId', $artId, \PDO::PARAM_INT);
        $stmt->bindParam(':artOmschrijving', $row['artOmschrijving'], \PDO::PARAM_STR);
        $stmt->bindParam(':artInkoop', $row['artInkoop'], \PDO::PARAM_STR);
        $stmt->bindParam(':artVerkoop', $row['artVerkoop'], \PDO::PARAM_STR);
        $stmt->bindParam(':artVoorraad', $row['artVoorraad'], \PDO::PARAM_INT);
        $stmt->bindParam(':artMinVoorraad', $row['artMinVoorraad'], \PDO::PARAM_INT);
        $stmt->bindParam(':artMaxVoorraad', $row['artMaxVoorraad'], \PDO::PARAM_INT);
        $stmt->bindParam(':artLocatie', $row['artLocatie'], \PDO::PARAM_STR);
        return $stmt->execute();
    }
}
?>
