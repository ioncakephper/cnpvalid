<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

include(".\\..\\js\\cnp_valid.php");

final class CnpCheckSumTest extends TestCase
{

    public function passValidCnp(): void {

        $validCNP = "1621126400074";
        $r = isChecksumValid($validCNP);
        $this->assertTrue($r);
    }

    
    public function failInvalidCnp(): void {

        $invalidCNP = "1621126400075";
        $r = isChecksumValid($invalidCNP);
        $this->assertTrue($r);
    }
}