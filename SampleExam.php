<?php

class SampleExam {

    function run() {
        $argv = file_get_contents('input.txt');
        foreach (explode("\n", $argv) as $row) {
            if (empty($row))
                continue;
            [$bin, $amount, $currency] = $this->getArrayFromJson($row);
            $alpha = $this->getBinResult($bin);
            $isEu = $this->isEu($alpha);
            $amntFixed = $this->getAmount($amount, $currency);
            echo round($amntFixed * ($isEu == true ? 0.01 : 0.02),2);
            echo "\n";
        }
    }

    /*
     * Get array from a json string and return array.
     * Input JSON String
     * Return Array from that string
     */

    function getArrayFromJson(String $row) {
        $array = json_decode($row);
        return [$array->bin, $array->amount, $array->currency];
    }

    /*
     * Get BIN result from BIN Code.
     * Input : BIN Code
     * Return Alpha or empty result
     */

    function getBinResult(int $bin) {
        $binResults = file_get_contents('https://lookup.binlist.net/' . $bin);
        if (!$binResults)
            return '';
        else {
            $r = json_decode($binResults);
            return $r->country->alpha2;
        }
    }

    /*
     * Checking that , provided currency is Euro or not.
     * Input String
     * Return Boolean true or false
     */

    function isEu(String $c) {
        $currency = ['AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES', 'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU', 'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK'];
        if (in_array($c, $currency)) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Get latest currency convirsion rate and return converted amount.
     * Input Amount and Currency
     * Return converted amount
     */

    function getAmount(float $amount, String $currency) {
        $latest_rate = @json_decode(file_get_contents('https://api.exchangeratesapi.io/latest'), true);
        if (isset($latest_rate['rates'][$currency]))
            $rate = $latest_rate['rates'][$currency];
        else
            $rate = 0;
        if ($currency == 'EUR' || $rate == 0) {
            return $amount;
        }
        if ($currency != 'EUR' || $rate > 0) {
            return $amount / $rate;
        }
    }

}
