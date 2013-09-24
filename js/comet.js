/**
script: Comet.js
name: Comet
author: Richard Roque <roquerichardneil@gmail.com>
description: Class that wraps Request.JSON class to implement long polling.
license: MIT-style license
requires:
- Core/MooTools
- Core/More	

Known limitations: 
- Doesn't work with another tab using the same browser.
*/

var Comet = new Class({
	Extends: Request.JSON,
	_try: 0,
	options: {
		max: 3,
		data: {}
	},
	initialize: function(options){
		this.parent(options);
	},
	send: function(options){
		this._try++;
		this.parent(options);
	},
	onSuccess: function(json, text){		
		this.parent(json, text);
		var changed = (json.timestamp != this.options.data.timestamp);
		var exceeds = (this._try >= this.options.max);
		
		if(exceeds) {
			this._try = 0;
			this.fireEvent('maxRequestExceeded');
			return;
		}		
		if(changed) {			
			this.options.data.timestamp = json.timestamp;			
			this._try = 0;		
			this.fireEvent('newData', json);
		}				
		this.send();	
	}
});


