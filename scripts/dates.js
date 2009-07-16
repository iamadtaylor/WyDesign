$(document).ready(function() {
	$('.dates').find('p').addClass('description');
	$('.dates li').hover(function() {
		
		$(this).find('p').stop().show();
		
	}, function() {
		
		$(this).find('p').stop().hide();
		
	});
	
});
