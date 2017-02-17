<?php

namespace TemplateReaderTask;

/**
 *
 * @author jesusalc
 */
class Router
{
    /**
    * echo contents to page with header for html
    *
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

}
