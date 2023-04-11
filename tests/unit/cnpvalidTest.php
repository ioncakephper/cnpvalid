<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

include(".\\..\\js\\cnp_valid.php");

final class CnpValidTest extends TestCase
{

    public function passValidCnp(): void {
        $validCnpValue = "1621126400074";
        $r = isCnpValid($validCnpValue);
        $this->assertTrue($r);
    }

    public function failCnpGender(): void {
        $invalidCnpValue = "1621126400074";
        $r = isCnpValid($invalidCnpValue);
        $this->assertFalse($r);
    }

    public function failCnpMonthNumber(): void {
        $invalidCnpValue = "1621326400074";
        $r = isCnpValid($invalidCnpValue);
        $this->assertFalse($r);
    }

    public function failCnpDay(): void {
        $invalidCnpValue = "1621131400074";
        $r = isCnpValid($invalidCnpValue);
        $this->assertFalse($r);
    }

    public function failCnpDayInFebruary(): void {
        $invalidCnpValue = "1620230400074";
        $r = isCnpValid($invalidCnpValue);
        $this->assertFalse($r);
    }
}