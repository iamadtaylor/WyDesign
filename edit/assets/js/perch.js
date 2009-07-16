if (typeof(Perch) == 'undefined') {
	Perch	= {};
	Perch.UI	= {};
}

Perch.UI.Global	= function()
{
	var init	= function() {
		$('body').addClass('js');
		enhanceCSS();
		initPopups();
		hideMessages();
	};
	
	var enhanceCSS = function() {
		$('#content #main-panel form div.error').prev().css('border-bottom', '0');
		$('#content #main-panel form div.edititem').prev().find('div:last').css('border-bottom', '0');
		$('#content form div.field').append('<div class="clear"></div>');
	};
	
	var initPopups = function() {
		$('a.assist').click(function(e){
			e.preventDefault();
			window.open($(this).attr('href'));
		});
	};
	
	var hideMessages = function() {
		if ($('p.alert-success')) {
			setTimeout("$('p.alert-success').selfHealingRemove()", 5000);
		};
	};
	
	return {
		init: init
	};
	
}();

jQuery.fn.selfHealingRemove = function(settings, fn) {
	if (jQuery.isFunction(settings)){
		fn = settings;
		settings = {};
	}else{
		settings = jQuery.extend({
			speed: 'slow'
		}, settings);
	};
	
	return this.each(function(){
		var self	= jQuery(this); 
		self.animate({
			opacity: 0
		}, settings.speed, function(){
			self.slideUp(settings.speed, function(){
				self.remove();
				if (jQuery.isFunction(fn)) fn();
			});
		});
	});
};


jQuery(function($) { Perch.UI.Global.init(); });