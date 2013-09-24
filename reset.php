<?php

@unlink('logs/messages.tmp');

require_once('classes/Message.php');

$_m = new Message();
$_m->name = "Anonymous";
$_m->message = "Hello! Thank you for having a quick look in my sample application. Please feel free to try it all you want. 
				BTW. This application will automatically clear all messages when it reach 50, so you still have 49 remaining messages to try.
				Thank you again and God bless to all";
$_m->cdate = date("F j, Y, g:i a");

$msgList = MessageList::getInstance();		
$msgList->save($_m);

header('location:./');