function Timer(callback, delay) {
	var timerId, start, status, remaining= delay;

	this.status = function() {
		return this.status;
    };
	
	this.play = function() {
		if(status == 'stopped'){
			window.clearInterval(timerId);
			status= 'playing';
			start = Date();
			timerId = window.setInterval(callback, remaining);
		}
		else if(status == 'paused'){
			window.clearInterval(timerId);
			status= 'playing';
			timerId = window.setInterval(callback, remaining);
		}
		
    };
	
	this.step = function() {
		if(status == 'playing'){
			window.clearInterval(timerId);
			status= 'stopped';
		}
    };

    this.pause = function() {
		if(status == 'playing'){
			window.clearInterval(timerId);
			status= 'paused';
			remaining -= Date() - start;
		}
    };
	
	if(!status){
		status= 'stopped';
		this.play();
	}
}