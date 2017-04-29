<?php
namespace Application\Utilility;

class Replace
{
    public static function replaceNullWithAlt($str, $alt)
    {
        return ($str == null ? $alt : $str);
    }
    
    public static function replaceEmptyAnonymity($str)
    {
        if (empty($str) || $str == 'Y') {
            return 1;
        } else if ($str == 'N') {
            return 0;
        } else {
            return 1;
        }
    }
}
