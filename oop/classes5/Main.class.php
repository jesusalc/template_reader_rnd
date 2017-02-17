<?php

namespace TemplateReaderTask;

/**
 *
 * @author jesusalc
 */
class Main
{

    function __construct() {

        $timer = new Timer();
        $clocked_time = $timer->clock_in();

        $router = new Router();
        $template = $router->get_url_section(1);
        if (empty($template)) {
            $template = "extra";
        }

        $fileLoader = new FileLoader();
        $html = $fileLoader->load_template($template);

        $dataLoader = new DataLoader();
        $keys = $dataLoader->get_keys();

        $stringReplacer = new StringReplacer();
        $html = $stringReplacer->replace_keys($html, $keys);

        $serverHelper = new ServerHelper();
        $serverHelper->serve_template($html);

        $clocked_time2 = $timer->clock_in();
        $timer->print_results($clocked_time2, $clocked_time);

    }



}
