<?php

namespace TemplateReaderTask;

/**
 *
 * @author jesusalc
 */
class ServerHelper
{

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

}
