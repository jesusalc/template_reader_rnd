<?php

namespace TemplateReaderTask;

/**
 *
 * @author jesusalc
 */
class FileLoader
{
    /**
    * Wrapper for file_get_contents
    *
    * @return string
    */
    function load_template($filename) {
        $file_to_load = "../../templates/" . $filename . ".tmpl";
        if (!file_exists($file_to_load)) {
            echo "FileNotFound - Error Loading:" . $file_to_load;
            die();
        } else {
            return file_get_contents($file_to_load);
        }
    }

}
