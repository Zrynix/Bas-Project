<?php
namespace Bas\classes;

use Bas\classes\Database;

class Leverancier extends Database {
    public $levId;
    public $levNaam;
    public $levContact;
    public $levEmail;
    public $levAdres;
    public $levPostcode;
    public $levWoonplaats;

    private $table_name = "Leverancier";

    public function __construct() {
        parent::__construct();
    }

    public function insertLeverancier(array $data) : bool {
        $sql = "INSERT INTO " . $this->table_name . " 
                (levNaam, levContact, levEmail, levAdres, levPostcode, levWoonplaats) 
                VALUES 
                (:levNaam, :levContact, :levEmail, :levAdres, :levPostcode, :levWoonplaats)";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':levNaam', $data['levNaam'], \PDO::PARAM_STR);
        $stmt->bindParam(':levContact', $data['levContact'], \PDO::PARAM_STR);
        $stmt->bindParam(':levEmail', $data['levEmail'], \PDO::PARAM_STR);
        $stmt->bindParam(':levAdres', $data['levAdres'], \PDO::PARAM_STR);
        $stmt->bindParam(':levPostcode', $data['levPostcode'], \PDO::PARAM_STR);
        $stmt->bindParam(':levWoonplaats', $data['levWoonplaats'], \PDO::PARAM_STR);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getLastInsertedId() {
        return self::$conn->lastInsertId();
    }

    public function readLeveranciers() : array {
        $sql = "SELECT levId, levNaam, levContact, levEmail, levAdres, levPostcode, levWoonplaats FROM " . $this->table_name;
        $stmt = self::$conn->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function readLeverancier(int $levId) : array {
        $sql = "SELECT levId, levNaam, levContact, levEmail, levAdres, levPostcode, levWoonplaats FROM " . $this->table_name . " WHERE levId = :levId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':levId', $levId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateLeverancier(array $data) : bool {
        $sql = "UPDATE " . $this->table_name . " 
                SET levNaam = :levNaam, levContact = :levContact, levEmail = :levEmail, levAdres = :levAdres, levPostcode = :levPostcode, levWoonplaats = :levWoonplaats 
                WHERE levId = :levId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':levNaam', $data['levNaam'], \PDO::PARAM_STR);
        $stmt->bindParam(':levContact', $data['levContact'], \PDO::PARAM_STR);
        $stmt->bindParam(':levEmail', $data['levEmail'], \PDO::PARAM_STR);
        $stmt->bindParam(':levAdres', $data['levAdres'], \PDO::PARAM_STR);
        $stmt->bindParam(':levPostcode', $data['levPostcode'], \PDO::PARAM_STR);
        $stmt->bindParam(':levWoonplaats', $data['levWoonplaats'], \PDO::PARAM_STR);
        $stmt->bindParam(':levId', $data['levId'], \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteLeverancier(int $levId) : bool {
        $sql = "DELETE FROM " . $this->table_name . " WHERE levId = :levId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':levId', $levId, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function dropDownLeverancier($row_selected = -1) {
        $lijst = $this->readLeveranciers();
        echo "<label for='Leverancier'>Choose a leverancier:</label>";
        echo "<select name='levId'>";
        foreach ($lijst as $row) {
            if ($row_selected == $row["levId"]) {
                echo "<option value='{$row["levId"]}' selected='selected'> {$row["levNaam"]}</option>\n";
            } else {
                echo "<option value='{$row["levId"]}'> {$row["levNaam"]}</option>\n";
            }
        }
        echo "</select>";
    }
}
?>
