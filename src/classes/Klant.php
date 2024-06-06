<?php
// Auteur: Amin
// Functie: definitie class Klant
namespace Bas\classes;

use PDO;
use PDOException;
use Bas\classes\Database;

class Klant extends Database {
    private $table_name = "Klant";

    // Methods

    /**
     * Haal alle klanten op uit de database mbv de method getKlanten()
     * en toon ze in een HTML-tabel
     */
    public function crudKlant(): void {
        try {
            $klanten = $this->getKlanten();
            $this->showTable($klanten);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Haal alle klanten op uit de database
     * @return array
     */
    public function getKlanten(): array {
        try {
            $sql = "SELECT * FROM $this->table_name";
            $stmt = self::$conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Haal een klant op basis van klantId
     * @param int $klantId
     * @return array
     */
    public function getKlant(int $klantId): array {
        try {
            $sql = "SELECT * FROM $this->table_name WHERE klantId = :klantId";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':klantId', $klantId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    /**
     * Toon een dropdown met klanten
     * @param int $row_selected
     */
    public function dropDownKlant($row_selected = -1): void {
        try {
            $klanten = $this->getKlanten();
            echo "<label for='Klant'>Choose a klant:</label>";
            echo "<select name='klantId'>";
            foreach ($klanten as $row) {
                $selected = ($row_selected == $row["klantId"]) ? "selected='selected'" : "";
                echo "<option value='{$row['klantId']}' $selected>{$row['klantNaam']} {$row['klantEmail']}</option>\n";
            }
            echo "</select>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Toon klanten in een HTML-tabel
     * @param array $klanten
     */
    private function showTable(array $klanten): void {
        echo "<table>";
        if (!empty($klanten)) {
            echo getTableHeader($klanten[0]);
            foreach ($klanten as $row) {
                echo "<tr>";
                echo "<td>{$row['klantNaam']}</td>";
                echo "<td>{$row['klantEmail']}</td>";
                echo "<td>{$row['klantWoonplaats']}</td>";
                echo "<td>{$row['klantAdres']}</td>";
                echo "<td>{$row['klantPostcode']}</td>";
                echo "<td><form method='post' action='update.php?klantId={$row['klantId']}'><button name='update'>Wzg</button></form></td>";
                echo "<td><form method='post' action='delete.php?klantId={$row['klantId']}'><button name='verwijderen'>Verwijderen</button></form></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Geen klanten gevonden</td></tr>";
        }
        echo "</table>";
    }

    /**
     * Verwijder een klant op basis van klantId
     * @param int $klantId
     * @return bool
     */
    public function deleteKlant(int $klantId): bool {
        try {
            $sql = "DELETE FROM $this->table_name WHERE klantId = :klantId";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':klantId', $klantId, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Update een klantgegevens
     * @param array $row
     * @return bool
     */
    public function updateKlant(array $row): bool {
        try {
            $sql = "UPDATE $this->table_name 
                    SET klantEmail = :klantEmail, klantNaam = :klantNaam, klantWoonplaats = :klantWoonplaats, 
                    klantAdres = :klantAdres, klantPostcode = :klantPostcode 
                    WHERE klantId = :klantId";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':klantId', $row['klantId'], PDO::PARAM_INT);
            $stmt->bindParam(':klantEmail', $row['klantEmail'], PDO::PARAM_STR);
            $stmt->bindParam(':klantNaam', $row['klantNaam'], PDO::PARAM_STR);
            $stmt->bindParam(':klantWoonplaats', $row['klantWoonplaats'], PDO::PARAM_STR);
            $stmt->bindParam(':klantAdres', $row['klantAdres'], PDO::PARAM_STR);
            $stmt->bindParam(':klantPostcode', $row['klantPostcode'], PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    /**
     * Bepaal het volgende beschikbare klantId
     * @return int
     */
    private function BepMaxKlantId(): int {
        $sql = "SELECT MAX(klantId) + 1 FROM $this->table_name";
        return (int)self::$conn->query($sql)->fetchColumn();
    }

    /**
     * Voeg een nieuwe klant toe aan de database
     * @param array $row Array met klantgegevens
     * @return bool True als het invoegen succesvol is, anders False
     */
    public function insertKlant(array $row): bool {
        try {
            self::$conn->beginTransaction();
            $klantId = $this->BepMaxKlantId();
            $sql = "INSERT INTO $
this->table_name (klantId, klantEmail, klantNaam, klantWoonplaats, klantAdres, klantPostcode)
                    VALUES (:klantId, :klantEmail, :klantNaam, :klantWoonplaats, :klantAdres, :klantPostcode)";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':klantId', $klantId, PDO::PARAM_INT);
            $stmt->bindParam(':klantEmail', $row['klantEmail'], PDO::PARAM_STR);
            $stmt->bindParam(':klantNaam', $row['klantNaam'], PDO::PARAM_STR);
            $stmt->bindParam(':klantWoonplaats', $row['klantWoonplaats'], PDO::PARAM_STR);
            $stmt->bindParam(':klantAdres', $row['klantAdres'], PDO::PARAM_STR);
            $stmt->bindParam(':klantPostcode', $row['klantPostcode'], PDO::PARAM_STR);
            $stmt->execute();
            self::$conn->commit();
            return true;
        } catch (PDOException $e) {
            self::$conn->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
