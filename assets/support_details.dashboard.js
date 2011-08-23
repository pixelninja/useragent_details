jQuery(function($){
   	//screen resolution
   	$('div.support_details dt.screen').next().text(screen.width + 'x' + screen.height);
   	//browser resolution
   	$('div.support_details dt.browser').next().text($(window).width() + 'x' + $(window).height());
   	//Flash detection
   	var flash = FlashDetect.installed ? 'Yes' : 'No';
   	$('div.support_details dt.flash-enabled').next().text(flash);
   	if(flash == 'Yes') $('div.support_details dt.flash-version').next().text(FlashDetect.major+'.'+FlashDetect.minor+'.'+FlashDetect.revision);
   		else $('div.support_details dt.flash-version').next().text('Flash is not supported');
   	//Flash detection
   	$('div.support_details dt.js').next().text('Yes');
   	//Colour depth
   	$('div.support_details dt.depth').next().text(screen.colorDepth + ' bit');
});