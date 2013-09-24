<?php

error_reporting(~E_ALL);

ignore_user_abort(true);
flush();
ob_flush();

require_once('classes/Message.php');

$msgListFile = 'logs/messages.tmp';
$_timestamp = intVal($_REQUEST['timestamp']);
$max = 10;
$try = 0;

if(!file_exists($msgListFile)) {
	file_put_contents($msgListFile, array());
}

while(!$exit) {
	$try++;
	clearstatcache();
	$timestamp = filemtime($msgListFile);
	if(($_timestamp!=$timestamp) || $try >= $max){		
		$msgList = unserialize(file_get_contents($msgListFile));				
		echo json_encode(array('timestamp'=>$timestamp, 'data'=>$msgList));
		die();
	}	
	echo str_repeat(" ", 255);		
	flush();
	ob_flush();
	if(connection_aborted()){
		die();
	}	
	sleep(1);
}