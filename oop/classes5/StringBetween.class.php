<?php

namespace TemplateReaderTask;

/**
 *
 * @author jesusalc
 */
class StringBetween
{
    /**
     *
     * @return string
     */
    function remove($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $oni = $ini + strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        $part_one = substr($string, 0, $ini);
        $part_two = substr($string, ($oni + $len + strlen($end)));
        return $part_one . $part_two;
    }


    /**
     * $parsed = get_string_between($fullstring, '[tag]', '[/tag]');
     */
    function get($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    /**
     *
     * @return string
     */
    function insert($string, $start, $end, $part_two){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $oni = $ini + strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        $part_one = substr($string, 0, $ini-1);
        $part_three = substr($string, ($oni + $len + strlen($end)-1));
        return $part_one . $part_two . $part_three;
    }

}
