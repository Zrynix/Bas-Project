<?php
namespace Bas\classes;

use Bas\classes\Database;

class Inkooporder extends Database {
    public $inkOrdId;
    public $inkOrdDatum;
    public $inkOrdStatus;
    public $levId;

    private $table_name = "Inkooporder";

    public function __construct() {
        parent::__construct();
    }

    public function createInkooporder(array $data) : bool {
        $sql = "INSERT INTO " . $this->table_name . " (inkOrdDatum, inkOrdStatus, levId) VALUES (:inkOrdDatum, :inkOrdStatus, :levId)";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':inkOrdDatum', $data['inkOrdDatum'], \PDO::PARAM_STR);
        $stmt->bindParam(':inkOrdStatus', $data['inkOrdStatus'], \PDO::PARAM_STR);
        $stmt->bindParam(':levId', $data['levId'], \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function readInkooporders() : array {
        $sql = "SELECT inkOrdId, inkOrdDatum, inkOrdStatus, levId FROM " . $this->table_name;
        $stmt = self::$conn->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function readInkooporder(int $inkOrdId) : array {
        $sql = "SELECT inkOrdId, inkOrdDatum, inkOrdStatus, levId FROM " . $this->table_name . " WHERE inkOrdId = :inkOrdId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':inkOrdId', $inkOrdId, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateInkooporder(array $data) : bool {
        $sql = "UPDATE " . $this->table_name . " SET inkOrdDatum = :inkOrdDatum, inkOrdStatus = :inkOrdStatus, levId = :levId WHERE inkOrdId = :inkOrdId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':inkOrdDatum', $data['inkOrdDatum'], \PDO::PARAM_STR);
        $stmt->bindParam(':inkOrdStatus', $data['inkOrdStatus'], \PDO::PARAM_STR);
        $stmt->bindParam(':levId', $data['levId'], \PDO::PARAM_INT);
        $stmt->bindParam(':inkOrdId', $data['inkOrdId'], \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteInkooporder(int $inkOrdId) : bool {
        $sql = "DELETE FROM " . $this->table_name . " WHERE inkOrdId = :inkOrdId";
        $stmt = self::$conn->prepare($sql);
        $stmt->bindParam(':inkOrdId', $inkOrdId, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function dropDownInkooporder($row_selected = -1) {
        $lijst = $this->readInkooporders();
        echo "<label for='Inkooporder'>Choose an inkooporder:</label>";
        echo "<select name='inkOrdId'>";
        foreach ($lijst as $row) {
            if ($row_selected == $row["inkOrdId"]) {
                echo "<option value='{$row["inkOrdId"]}' selected='selected'> {$row["inkOrdId"]}</option>\n";
            } else {
                echo "<option value='{$row["inkOrdId"]}'> {$row["inkOrdId"]}</option>\n";
            }
        }
        echo "</select>";
    }
}
?>
