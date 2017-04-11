<?php
/**
 * Created by PhpStorm.
 * User: raphael
 * Date: 11/04/2017
 * Time: 23:24
 */
namespace App\Services;

class Utils {

    static public function formatString($element){

        if ($element == null){
            return null;
        }
        $string = $element->__toString();
        return $string != null ? $string : null;
    }

}