$('<div id="fb-root"></div>').prependTo('body');
(
	function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if(d.getElementById(id))
			return;
		js= d.createElement(s);
		js.id= id;
		js.src= "//connect.facebook.net/pt_BR/all.js#xfbml=1";
		fjs.parentNode.insertBefore(js, fjs);
	}
	(document, 'script', 'facebook-jssdk')
);