<?php

namespace TemplateReaderTask;

/**
 *
 * @author jesusalc
 */
class StringManipulation
{
    /**
    *
    * @return string
    */
    function remove_string_between($string, $start, $end){
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
    function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }


    /**
    * Replaces values with {{$key}} for $value
    * given an array inside $replace_array
    * inside the blobed long string inside $html
    *
    * @return string
    */
    function replace_simple_keys($text, Array $replace_array) {
        // $return = str_ireplace( $search,  $replace,  $text);
        $return = $text;
        foreach ($replace_array as $key => $value) {
            $return = replace_strings('/\{\{'.$key.'\}\}/i',  $value, $return);
        }
        return $return;
    }


    /**
    * Wrapper for preg_replace that replaces strings
    *
    * @return string
    */
    function replace_strings($key,  $value, $text) {
        // $return  = str_replace( "{{$key}}",  $value,  $text);
        return preg_replace($key,  $value, $text);
    }

    /**
    *
    * @return string
    */
    function insert_string_between($string, $start, $end, $part_two){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $oni = $ini + strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        $part_one = substr($string, 0, $ini-1);
        $part_three = substr($string, ($oni + $len + strlen($end)-1));
        return $part_one . $part_two . $part_three;
    }


    /**
    *
    * @return string
    */
    function replace_keys($text, Array $replace_array, $parent = "") {
        $return = $text;
        foreach ($replace_array as $key => $value) {
            // simple replacement of {{key}}
            if (gettype($value) === "string") {
                $return = replace_strings('/\{\{'.$key.'\}\}/i',  $value, $return);
            }
            // start {{#each Array}} of Arrays key => [Array[],Array[],Array[]]
            if (gettype($value) === "array" && gettype($key) === "string") {
                $block = get_string_between($return, "{{#each ".$key."}}", "{{/each}}");
                $build = $block;
                $any_unless = strpos(".".$block, "{{#unless");
                $if = "";
                $else = "";
                $condition = "";
                if ($any_unless > 0) {
                    // "{{Thing}} are {{Desc}}{{#unless @last}},{{else}}!{{/unless}}"
                    $unless = get_string_between($block , "{{#unless @last}}", "{{/unless}}");
                    $else = "";
                    $if = "";
                    $condition = "";
                    if (strpos($block, "@last") > 0 && strpos($block, "{{else}}") > 0) {
                        $condition = "unless last";
                        $if = get_string_between($block , "{{#unless @last}}", "{{else}}");
                        $else = get_string_between($block , "{{else}}", "{{/unless}}");
                    } else {
                        $if = get_string_between($block , "{{#unless @last}}", "{{/unless}}");
                    }

                    $build = remove_string_between($block, "{{#unless @last}}", "{{/unless}}");
                }
                $construct = "";
                // count
                $count = 0;
                foreach ($value as $underkey => $undervalue) {
                    $count++;
                }
                foreach ($value as $underkey => $undervalue) {
                    $construct .= $build;
                    foreach ($undervalue as $kinderkey => $kindervalue) {
                        $construct = replace_strings('/\{\{'.$kinderkey.'\}\}/i',  $kindervalue, $construct);
                    }
                    $count--;
                    if ($condition !== "") {
                        if ($condition === "unless last" && $count) {
                            $construct .= $if;
                        } else {
                            $construct .= $else;
                        }
                    }
                }
                $return = insert_string_between($return, "{{#each ".$key."}}", "{{/each}}", $construct);
            }
            // inside, between {{#each}} ..0[ key => value ],1[ key value],2[],3[].. {{/each}}
            if (gettype($value) === "array" && gettype($key) === "integer" &&  $parent !== "") {

            }
        }

        return $return;
    }

}
