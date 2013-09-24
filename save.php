<?php

require_once('classes/Message.php');

if($_REQUEST['act']=='save') {	
	$msg = new Message();
	$msg->name = $_REQUEST['name'] ?$_REQUEST['name']:"Anonymous";
	$msg->message = $_REQUEST['msg'];
	
	$msgList = MessageList::getInstance();
		
	$msgList->save($msg);
}