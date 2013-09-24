<?php

class MessageList {
	var $messages = array();
	static $msgListFile = 'logs/messages.tmp';
	public static function getInstance() {
		if(!file_exists(self::$msgListFile)) {
			file_put_contents(self::$msgListFile, array());
		}		
		$instance = unserialize(file_get_contents(self::$msgListFile));
		if(!($instance instanceOf MessageList)){
			$instance = new MessageList();
		}
		return $instance;
	}
	
	public function save(Message $m){		
		if(count($this->messages) >= 50){
			$this->messages = array();
			$_m = new Message();
			$_m->name = "Anonymous";
			$_m->message = "Hello! Thank you for having a quick look in my sample application. Please feel free to try it all you want. 
							BTW. This application will automatically clear all messages when it reach 50, so you still have 49 remaining messages to try.
							Thank you again and God bless to all";
			$_m->cdate = date("F j, Y, g:i a");
			$this->messages[] = $_m;
		}
		$this->messages[] = $m;		
		file_put_contents(self::$msgListFile, serialize($this));
	}
}

class Message {}