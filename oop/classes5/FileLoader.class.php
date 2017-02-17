<?php

namespace TemplateReaderTask;

/**
 *
 * @author jesusalc
 */
class Router
{
    /**
    * Wrapper for file_get_contents
    *
    * @return string
    */
    function load_template($filename) {
        return file_get_contents("../templates/" . $filename . ".tmpl");
    }

}
