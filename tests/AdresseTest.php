<?php

namespace App\Tests;

use App\Entity\Adresse;
use PHPUnit\Framework\TestCase;

class AdresseTest extends TestCase
{
    public function testCreationAdresse(): void
    {
        $adresse = new Adresse("1654, rue du test, 22300, Lannion");

        $this->assertEquals("1654", $adresse->getNumero(), "Numero invalide");
        $this->assertEquals("RUE DU TEST", $adresse->getNom(), "Nom invalide");
        $this->assertEquals("22300", $adresse->getCodePostal(), "Code Postal invalide");
        $this->assertEquals("LANNION", $adresse->getVille(), "Ville invalide");
    }

    public function testCreationAdresseSpecialChar(): void
    {
        $adresse = new Adresse("1654, rûE du tÉst, 22300, Lannion");

        $this->assertEquals("1654", $adresse->getNumero(), "Numero invalide");
        $this->assertEquals("RUE DU TEST", $adresse->getNom(), "Nom invalide");
        $this->assertEquals("22300", $adresse->getCodePostal(), "Code Postal invalide");
        $this->assertEquals("LANNION", $adresse->getVille(), "Ville invalide");
    }
}
