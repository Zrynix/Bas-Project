<?php
namespace Bas\classes;

class Inkooporder {
    private $pdo;

    public function __construct() {
        $this->pdo = new \PDO('mysql:host=your_host;dbname=your_db', 'your_user', 'your_password');
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function insertInkooporder($inkoopordergegevens) {
        $sql = "INSERT INTO inkooporders (levId, artId, inkOrdDatum, inkOrdBestAantal, inkOrdStatus) VALUES (:levId, :artId, :inkOrdDatum, :inkOrdBestAantal, :inkOrdStatus)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($inkoopordergegevens);
        return $stmt->rowCount();
    }

    public function getLastInsertedId() {
        return $this->pdo->lastInsertId();
    }
}
?>
