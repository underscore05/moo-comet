<?php



class MessageList {
	static $msgListFile = 'logs/messages.tmp';
	public static function getInstance() {
		$instance = unserialize(file_get_contents(self::$msgListFile));
		if(!($instance instanceOf MessageList)){
			$instance = new MessageList();
		}
		return $instance;
	}
	
	public function save(Message $m){		
		if(count($this->messages) >= 50){
			$this->messages = array();
		}
		$this->messages[] = $m;
		file_put_contents(self::$msgListFile, serialize($this));
	}
}

class Message {}