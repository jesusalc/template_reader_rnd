<?php

namespace TemplateReaderTask;

/**
 *
 * @author jesusalc
 */
class DataLoader
{


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


