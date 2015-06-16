<?php
namespace Massimo\BlogBundle\Service;

class Slugger {
    //put your code here
    function getSlug($str, $replace=array(), $delimiter='-') {
    //
    if( !empty($replace) ) {
        $str = str_replace((array)$replace, ' ', $str);
    }
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);    
    $clean=strip_tags($clean);
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    return $clean;
    }
}