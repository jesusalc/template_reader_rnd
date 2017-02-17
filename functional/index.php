<?php

/**
 *
 * SPEED PING RESEARCH
 * $clocked_time = clockIn();
 *	// header('Location:'.basename(__FILE__, '.php')."?PING_TIME=".$ping_time);
 *	header ( 'OriginalRequestTimeFloat:' . $_SERVER ['REQUEST_TIME_FLOAT'] );
 *
 *	// Removing Header since it will just work around the server
 *	$_POST ['OriginalRequestTimeFloat'] = $_SERVER ['REQUEST_TIME_FLOAT'];
 *
 */
function clockIn() {
	$mtime = microtime ();
	$mtime = explode ( ' ', $mtime );
	$mtime = $mtime [1] + $mtime [0];
	$starttime = $mtime;
	return $starttime;
}


/**
 *
 *
 *	// Now minus the original starting time
 *	$serverTookTime2 = timerDiff ( $clocked_time, $_POST ['OriginalRequestTimeFloat'] );
 *	$speed = timerDiff ( $clocked_time, $_POST ['OriginalRequestTimeFloat'] );
 *  $clocked_time2 = clockIn();
 *  $speed = timerDiff ( $clocked_time2, $clocked_time );
 * 	echo sprintf ( "Execution speed is %0.3f kb/s", $speed );
 *	$_POST ['speed'] = $serverTookTime2;
 *	$_SERVER ['speed'] = $serverTookTime2;
 *	$_SESSION ['speed'] = $serverTookTime2;
 *	$_GLOBALS ['speed'] = $serverTookTime2;
 */
function timerDiff($endtime, $starttime) {
	$totaltime = round ( ($endtime - $starttime), 5 );
	return $totaltime;
}


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
