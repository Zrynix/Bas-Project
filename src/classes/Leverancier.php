<?php
namespace Bas\classes;

use Bas\classes\Database;


class Leverancier {
    private $pdo;

    public function __construct() {
        $this->pdo = new \PDO('mysql:host=your_host;dbname=your_db', 'your_user', 'your_password');
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function insertLeverancier($leveranciergegevens) {
        $sql = "INSERT INTO leveranciers (levNaam, levEmail, levWoonplaats, levAdres, levPostcode) VALUES (:levNaam, :levEmail, :levWoonplaats, :levAdres, :levPostcode)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($leveranciergegevens);
        return $stmt->rowCount();
    }

    public function getLastInsertedId() {
        return $this->pdo->lastInsertId();
    }
}
?>
