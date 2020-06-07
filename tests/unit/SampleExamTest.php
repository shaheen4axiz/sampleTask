<?php

use PHPUnit\Framework\TestCase;

class SampleExamTest extends TestCase {

   
    public function testGetArrayFromJson() {
        require_once 'SampleExam.php';
        $sampleExam = new SampleExam();
        $this->assertNotEmpty($sampleExam->getArrayFromJson('{"bin":"45717360","amount":"100.00","currency":"EUR"}'));
        $this->assertIsArray($sampleExam->getArrayFromJson('{"bin":"45717360","amount":"100.00","currency":"EUR"}'));
        $this->assertEquals(count($sampleExam->getArrayFromJson('{"bin":"45717360","amount":"100.00","currency":"EUR"}')),3);
    }
    public function testGetBinResult() {
        require_once 'SampleExam.php';
        $sampleExam = new SampleExam();
        $bin = '516793';
        $this->assertNotEmpty($sampleExam->getBinResult($bin));
    }

    public function testAmount() {
        require_once 'SampleExam.php';
        $sampleExam = new SampleExam();
        $currency = 'USD';
        $amount = '100';
        $this->assertNotEmpty($sampleExam->getAmount($amount, $currency));
    }

}
