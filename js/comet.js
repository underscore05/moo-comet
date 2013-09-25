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
		delayPerRequest: 10,
		max: 3,
		data: {}
	},
	initialize: function(options){
		var self = this;
		this.parent(options);
		this.addEvents({
			onFailure: function() { self.send(); },
			onTimeout: function() { self.send(); },
			onException: function() { self.send(); }
		});
	},
	send: function(options){
		var exceeds = (this._try >= this.options.max);
		if(exceeds) {
			this._try = 0;
			this.fireEvent('maxRequestExceeded');
			return;
		}
		this._try++;
		this.parent(options);
	},
	onSuccess: function(json, text){		
		var self = this;
		this.parent(json, text);
		var changed = (json.timestamp != this.options.data.timestamp);		
		if(changed) {
			this.options.data.timestamp = json.timestamp;			
			this._try = 0;		
			this.fireEvent('newData', json);
		}
		console.log("Sending another request after "+this.options.delayPerRequest+" seconds...");		
		this.send.delay(this.options.delayPerRequest * 1000, self);	
	}
});


