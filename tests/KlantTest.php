<?php
// auteur: Amin
// functie: unittests class Klant

use PHPUnit\Framework\TestCase;
use Bas\classes\Klant;

// Filename moet gelijk zijn aan de classname KlantTest
class KlantTest extends TestCase {
    
    protected $klant;

    protected function setUp(): void {
        $this->klant = new Klant();
    }

    // Methods moeten starten met de naam test....
    public function testGetKlanten() {
        $klanten = $this->klant->getKlanten();
        $this->assertIsArray($klanten);
        $this->assertTrue(count($klanten) > 0, "Aantal moet groter dan 0 zijn");
    }

    public function testGetKlant() {
        $klantId = 1; 
        $klant = $this->klant->getKlant($klantId);
        $this->assertEquals($klantId, $klant['klantId']);
    }

// test data
    public function testInsertKlantTrue() {
        $testData = [
            'klantEmail' => 'test@example.com',
            'klantNaam' => 'Test',
            'klantAdres' => 'Test Adres 303',
            'klantPostcode' => '383HF',
            'klantWoonplaats' => 'Test'
        ];
        
        $result = $this->klant->insertKlant($testData);
        $this->assertTrue($result);
	}
}

?>
