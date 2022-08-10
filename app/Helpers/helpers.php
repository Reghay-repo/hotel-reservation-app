<?php

namespace App\Helpers;

use Carbon\Carbon;
use NumberFormatter;
use Illuminate\Support\Str;

class Helper
{
    public static function convertToRupiah($price)
    {
        
        $price_rupiah = "DH. " . number_format($price, 1, ',');
        return $price_rupiah;
    }

    public static function thisMonth()
    {
        return Carbon::parse(Carbon::now())->format('m');
    }

    public static function thisYear()
    {
        return Carbon::parse(Carbon::now())->format('Y');
    }

    public static function dateDayFormat($date)
    {
        return Carbon::parse($date)->isoFormat('dddd, D MMM YYYY');
    }

    public static function dateFormat($date)
    {
        return Carbon::parse($date)->isoFormat('D MMM YYYY');
    }

    public static function dateFormatTime($date)
    {
        return Carbon::parse($date)->isoFormat('D MMM YYYY H:m:s');
    }

    public static function dateFormatTimeNoYear($date)
    {
        return Carbon::parse($date)->isoFormat('D MMM, hh:mm a');
    }

    public static function getDateDifference($check_in, $check_out)
    {
        $check_in = strtotime($check_in);
        $check_out = strtotime($check_out);
        $date_difference = $check_out - $check_in;
        $date_difference = round($date_difference / (60 * 60 * 24));
        
        return $date_difference;
    }

    public static function plural($value, $count)
    {
        return Str::plural($value, $count);
    }

    public static function getColorByDay($day)
    {
        $color = '';
        if ($day == 1) {
            $color = 'bg-danger';
        } else if ($day > 1 && $day < 4) {
            $color = 'bg-warning';
        } else {
            $color = 'bg-success';
        }
        return $color;
    }

    public static function getTotalPayment($day, $price)
    {
        return $day * $price;
    }


    // public static function getDirhamCurrency(float $number)
    // {
    //     $decimal = round($number - ($no = floor($number)), 2) * 100;
    //     $hundred = null;
    //     $digits_length = strlen($no);
    //     $i = 0;
    //     $str = array();
    //     $words = array(0 => '', 1 => 'un', 2 => 'deux',
    //         3 => 'trois', 4 => 'quatre', 5 => 'cinq', 6 => 'six',
    //         7 => 'sept', 8 => 'huit', 9 => 'neuf',
    //         10 => 'dix', 11 => 'onze', 12 => 'douze',
    //         13 => 'treize', 14 => 'quatorze', 15 => 'quinze',
    //         16 => 'seize', 17 => 'dix-sept', 18 => 'dix-huit',
    //         19 => 'dix-neuf', 20 => 'vingt', 30 => 'trente',
    //         40 => 'forty', 50 => 'cinquante', 60 => 'soixante',
    //         70 => 'cent','mille' );
    //     while( $i < $digits_length ) {
    //         $divider = ($i == 2) ? 10 : 100;
    //         $number = floor($no % $divider);
    //         $no = floor($no / $divider);
    //         $i += $divider == 10 ? 1 : 2;
    //         if ($number) {
    //             $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
    //             $hundred = ($counter == 1 && $str[0]) ? ' et ' : null;
    //             $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
    //         } else $str[] = null;
    //     }
    //     $Rupees = implode('', array_reverse($str));
    //     $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    //     return ($Rupees ? $Rupees . 'Dirham ' : '') . $paise;
    // }

    public static function getDirhamCurrency(float $price) {

        $formater = new NumberFormatter("fr", NumberFormatter::SPELLOUT);
         return $formater->format($price) . ' Dirhams';  
    }

    

}
