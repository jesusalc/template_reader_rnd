<?php

namespace TemplateReaderTask;

/**
 *
 * @author jesusalc
 */
class StringReplacer extends StringBetween
{
    /**
     * Wrapper for preg_replace that replaces strings
     *
     * @return string
     */
    function replace_string($key,  $value, $text) {
        // $return  = str_replace( "{{$key}}",  $value,  $text);
        return preg_replace($key,  $value, $text);
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
            $return = $this->replace_string('/\{\{'.$key.'\}\}/i',  $value, $return);
        }
        return $return;
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
                $return = $this->replace_string('/\{\{'.$key.'\}\}/i',  $value, $return);
            }
            // start {{#each Array}} of Arrays key => [Array[],Array[],Array[]]
            if (gettype($value) === "array" && gettype($key) === "string") {
                $return = $this->get_block_morphed_insert($return, $key, $value);
            }
            // inside, between {{#each}} ..0[ key => value ],1[ key value],2[],3[].. {{/each}}
            if (gettype($value) === "array" && gettype($key) === "integer" &&  $parent !== "") {
                //todo feature
            }
        }

        return $return;
    }


    /**
     *
     * @return int
     */
    private function get_count($value){
        // count
        $count = 0;
        foreach ($value as $underkey => $undervalue) {
            $count++;
        }
        return $count;
    }


    /**
     *
     * @return string
     */
    private function get_morphed_insert($return, $key, $value, $condition, $if, $else, $build) {
        $construct = "";
        $count = $this->get_count($value);

        foreach ($value as $underkey => $undervalue) {
            $construct .= $build;
            foreach ($undervalue as $kinderkey => $kindervalue) {
                $construct = $this->replace_string('/\{\{'.$kinderkey.'\}\}/i',  $kindervalue, $construct);
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
        return $this->insert_between($return, "{{#each ".$key."}}", "{{/each}}", $construct);
    }


    /**
     *
     * @return string
     */
    private function get_block_morphed_insert($return, $key, $value) {
        $template_block = $this->get_between($return, "{{#each ".$key."}}", "{{/each}}");

        $build = $template_block;
        $any_unless = strpos(".".$template_block, "{{#unless");
        $if = "";
        $else = "";
        $condition = "";
        if ($any_unless > 0) {
            // "{{Thing}} are {{Desc}}{{#unless @last}},{{else}}!{{/unless}}"
            $unless = $this->get_between($template_block , "{{#unless @last}}", "{{/unless}}");

            $else = "";
            $if = "";
            $condition = "";
            if (strpos($template_block, "@last") > 0 && strpos($template_block, "{{else}}") > 0) {
                $condition = "unless last";
                $if = $this->get_between($template_block , "{{#unless @last}}", "{{else}}");
                $else = $this->get_between($template_block , "{{else}}", "{{/unless}}");
            } else {
                $if = $this->get_between($template_block , "{{#unless @last}}", "{{/unless}}");
            }

            $build = $this->remove_between($template_block, "{{#unless @last}}", "{{/unless}}");
        }
        return $this->get_morphed_insert($return, $key, $value, $condition, $if, $else, $build);
    }
}
