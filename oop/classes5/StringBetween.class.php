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
    public function remove_between($string, $start, $end){
        $ini = $this->get_ini($string, $start);
        $len = $this->get_len($string, $end, $ini);

        $oni = $ini + strlen($start);
        $part_one = substr($string, 0, $ini);
        $part_two = substr($string, ($oni + $len + strlen($end)));
        return $part_one . $part_two;
    }


    /**
     * Sample use: $parsed = $this->get_between($fullstring, '[tag]', '[/tag]');
     */
    public function get_between($string, $start, $end){
        $ini = $this->get_ini($string, $start);
        $len = $this->get_len($string, $end, $ini);

        $ini += strlen($start);
        return substr($string, $ini, $len);
    }

    /**
     *
     * @return string
     */
    public function insert_between($string, $start, $end, $part_two){
        $ini = $this->get_ini($string, $start);
        $len = $this->get_len($string, $end, $ini);

        $oni = $ini + strlen($start);
        $part_one = substr($string, 0, $ini-1);
        $part_three = substr($string, ($oni + $len + strlen($end)-1));
        return $part_one . $part_two . $part_three;
    }

    private function get_ini($string, $start) {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        return $ini;
    }

    private function get_len($string, $end, $ini){
        return strpos($string, $end, $ini) - $ini;
    }
}
