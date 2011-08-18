jQuery(function($){
   	var browser_width = $(window).width();
   	var browser_height = $(window).height(); 
   	//screen resolution
   	$('div.support_details dt.screen').next().text(screen.width + 'x' + screen.height);
   	//browser resolution
   	$('div.support_details dt.browser').next().text(browser_width + 'x' + browser_height);
   	//Flash detection
   	$('div.support_details dt.flash-enabled').next().text(FlashDetect.installed ? 'Yes' : 'No');
   	$('div.support_details dt.flash-version').next().text(FlashDetect.major+'.'+FlashDetect.minor+'.'+FlashDetect.revision);
   	//Flash detection
   	$('div.support_details dt.js').next().text('Yes');
   	//Colour depth
   	$('div.support_details dt.depth').next().text(screen.colorDepth + ' bit');
   	
   	console.log($.browser);
});