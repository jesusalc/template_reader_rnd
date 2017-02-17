<?php

namespace TemplateReaderTask;

/**
 *
 * @author jesusalc
 */
class Main
{


    $clocked_time = clockIn();
    require "functions.php";


    $template = get_route_section(1);
    if (empty($template)) {
        $template = "extra";
    }
    $html = load_template($template);
    $keys = get_keys();


    $html = replace_keys($html, $keys);
    serve_template($html);

    $clocked_time2 = clockIn();
    $speed = timerDiff ( $clocked_time2, $clocked_time );
    echo " \n\n";
    echo sprintf ( "Clocked time 1 %0.7f kb/s \n", $clocked_time2 );
    echo sprintf ( "Clocked time 2 %0.7f kb/s \n", $clocked_time );
    echo "=================================== \n";
    echo sprintf ( "Execution speed is %0.7f kb/s \n", $speed );
    echo " \n\n";

}
