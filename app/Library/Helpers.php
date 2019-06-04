<?php

namespace App\Library;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use ApaiIO\ApaiIO;
use Nathanmac\Utilities\Parser\Facades\Parser;

class Helpers
{

    public function __construct()
    {
    }
    
    // Extract the OL author ID from a view URL
    public static function getAuthorIdFromUrl($url) {
        
        $idOn   = str_after($url,'/authors/');
        $split  = explode('/', $idOn);
        
        return $split[0];
    }
    
    // Convert ISBN13 to ISBN10 if needed
    public static function isbn13_to_10($isbn) {
        if (preg_match('/^\d{3}(\d{9})\d$/', $isbn, $m)) {
            $sequence = $m[1];
            $sum = 0;
            $mul = 10;
            for ($i = 0; $i < 9; $i++) {
                $sum = $sum + ($mul * (int) $sequence{$i});
                $mul--;
            }
            $mod = 11 - ($sum%11);
            if ($mod == 10) {
                $mod = "X";
            }
            else if ($mod == 11) {
                $mod = 0;
            }
            $isbn = $sequence.$mod;
        }
        return $isbn;
    }
    
    // Convert ISBN10 to ISBN13 if needed
    public static function genchksum13($isbn)
    {
        $isbn = trim($isbn);
        $tb = 0;
        for ($i = 0; $i <= 12; $i++)
        {
            $tc = substr($isbn, -1, 1);
            $isbn = substr($isbn, 0, -1);
            $ta = ($tc*3);
            $tci = substr($isbn, -1, 1);
            $isbn = substr($isbn, 0, -1);
            $tb = $tb + $ta + $tci;
        }

        $tg = ($tb / 10);
        $tint = intval($tg);
        if ($tint == $tg) { return 0; }
        $ts = substr($tg, -1, 1);
        $tsum = (10 - $ts);
        return $tsum;
    }
    public static function isbn10_to_13($isbn)
    {
        $isbn = trim($isbn);
        if(strlen($isbn) == 12){ // if number is UPC just add zero
            $isbn13 = '0'.$isbn;}
        else
        {
            $isbn2 = substr("978" . trim($isbn), 0, -1);
            $sum13 = self::genchksum13($isbn2);
            $isbn13 = $isbn2.$sum13;
        }
        return $isbn13;
    }
    
}
