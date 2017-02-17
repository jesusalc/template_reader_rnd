<?php

namespace TemplateReaderTask;

/**
 *
 * @author jesusalc
 */
class DataLoader
{

    /**
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
}


