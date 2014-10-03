<?php

namespace Helper;


class FormatNumber extends \Phalcon\Mvc\User\Component {

    public function number($number, $decimals = 2) {
        return number_format($number, 0, '.', ',');     
    }

    public function currency($amount, $currencyKey = '$') {
        if ($currencyKey == 'VND') {
            return number_format($amount, 0, '.', ',') . 'đ';
        } elseif ($currencyKey == 'USD') {
            return '$' . number_format($amount, 2, '.', ',');
        } else {
            return $currencyKey . number_format($amount, 2, '.', ',');
        }
    }

    public function percent($number) {
        $checkNumber = $number * 100;

        if ($checkNumber % 100 == 0) {
            $decimals = 0;
        } elseif ($checkNumber % 10 == 0) {
            $decimals = 1;
        } else {
            $decimals = 2;
        }

        return number_format($number, $decimals) . "%";
    }

    public function filesize($bytes, $unit = "", $decimals = 2, $sizeSymbol = true) {
        $units = array('B' => 0, 'KB' => 1, 'MB' => 2, 'GB' => 3, 'TB' => 4, 
                'PB' => 5, 'EB' => 6, 'ZB' => 7, 'YB' => 8);

        $value = 0;
        if ($bytes > 0) {
            // Generate automatic prefix by bytes 
            // If wrong prefix given
            if (!array_key_exists($unit, $units)) {
                $pow = floor(log($bytes)/log(1024));
                $unit = array_search($pow, $units);
            }

            // Calculate byte value by prefix
            $value = ($bytes/pow(1024,floor($units[$unit])));
        }

        // If decimals is not numeric or decimals is less than 0 
        // then set default value
        if (!is_numeric($decimals) || $decimals < 0) {
            $decimals = 2;
        }

        // Format output
        if ($sizeSymbol) {
            return sprintf('%.' . $decimals . 'f '.$unit, $value);
        } else {
            return sprintf('%.' . $decimals . 'f', $value);
        }
    }

    public function phone($size) {
        $number = str_replace(array(',', '.', ' '), array('', '', ''), $number);

        return substr($number, 0, strlen($number) - 6) . '.' . substr($number, -6, 3) . '.' . substr($number, -3, 3);
    }
}