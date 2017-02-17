<?php


/**
 * Wrapper for preg_replace that replaces strings
 *
 * @author jesusalc
 * @return string
 */
function replace_strings($key,  $value, $text) {
    // $return  = str_replace( "{{$key}}",  $value,  $text);
    return preg_replace($key,  $value, $text);
}


/**
 * Replaces values with {{$key}} for $value
 * given an array inside $replace_array
 * inside the blobed long string inside $html
 *
 * @author jesusalc
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
 *
 * @author jesusalc
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
 *
 * @author jesusalc
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
 * @author jesusalc
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


/**
 * Wrapper for file_get_contents
 *
 * @author jesusalc
 * @return string
 */
function load_template($filename) {
    return file_get_contents("../templates/" . $filename . ".tmpl");
}


/**
 * Get language short code
 *
 * @author jesusalc
 * @return string
 */
function get_language($default){
    $lang = "";
    if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    } else {
        $lang = $default;
    }
    return $lang;
}


/**
 * echo contents to page with header for html
 *
 * @author jesusalc
 */
function serve_template($html){
    # Serve Page as html
    header("Content-Type:text/html");
    echo $html;
}


/**
 * echo contents to page with header for html
 *
 * @author jesusalc
 * @return string
 */
function get_subdomain_section($section){
    if (isset($_SERVER) && isset($_SERVER['REQUEST_URI'])) {
        return explode('.', $_SERVER['HTTP_HOST'])[$section];
    } else {
        return "";
    }
}

function get_route_section($section){
    if (isset($_SERVER) && isset($_SERVER['REQUEST_URI'])) {
        return explode('/', $_SERVER['REQUEST_URI'])[$section];
    } else {
        return "";
    }
}


/**
 * @author jesusalc
 * @return array
 */
function get_localhost_keys() {
    $keys = array();
    $host = $_SERVER['HTTP_HOST'];
    if ($host == 'localhost'){
        $keys[""] = "";
    } else {
        $keys[""] = "";
    }
    return $keys;
}


/**
 * echo contents to page with header for html
 *
 * @author jesusalc
 * @return array
 */
function get_keys(){
    $keys = array();

    $keys["name"] = "Pancho Villa";
    $keys["Staff"] = "This staff was here";
    $keys["Stuff"] = [
    [
        "Thing" => "roses",
        "Desc"  => "red"
    ],
    [
        "Thing" => "violets",
        "Desc"  => "blue"
    ],
    [
        "Thing" => "you",
        "Desc"  => "able to solve this"
    ],
    [
        "Thing" => "we",
        "Desc"  => "interested in you"
    ]
    ];
    return $keys;
}

