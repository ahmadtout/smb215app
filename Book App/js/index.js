var app = {
	// Application Constructor
	initialize: function() {
	this.bindEvents();
	},
	// Bind Event Listeners
	//
	// Bind any events that are required on startup. Common events are:
	// 'load', 'deviceready', 'offline', and 'online'.
	bindEvents: function() {
	document.addEventListener('deviceready', this.onDeviceReady, false);
	//resume update HOmePage
	document.addEventListener("resume", this.onResume, false);
	},
	
	onResume: function() {
		 
		 
		 
	},
	// deviceready Event Handler
	//
	// The scope of 'this' is the event. In order to call the 'receivedEvent'
	// function, we must explicity call 'app.receivedEvent(...);'
	onDeviceReady: function() {
  	
  	 MyDeviceReady();
 
	},
	// Update DOM on a Received Event
	receivedEvent: function(id) {
		
		 
	},
	// result contains any message sent from the plugin call
	successHandler: function(result) {
		console.log('Callback Success! Result = '+result)
	},
	errorHandler:function(error) {
		alert(error);
	}
	 
};
 