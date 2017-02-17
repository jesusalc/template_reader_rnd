<?php

namespace TemplateReaderTask;

/**
 *
 * @author jesusalc
 */
class Router
{

   /**
     * @return string
     */
    function get_url_section($section){
        if (isset($_SERVER) && isset($_SERVER['REQUEST_URI'])) {
            return explode('/', $_SERVER['REQUEST_URI'])[$section];
        } else {
            return "";
        }
    }

}
