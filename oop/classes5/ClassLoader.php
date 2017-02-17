<?php

namespace TemplateReaderTask;

foreach (glob("*.class.php") as $filename) {
    // echo " LOADING:" . ($filename) . "\n";
    require($filename);
}
$filename = null;
unset($filename);
