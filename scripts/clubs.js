$(document).ready(function() {simpleAccordion();});

function simpleAccordion() {
  $('#clubs ul').hide();
  $('#clubs li h3').click(
    function() {
        // $(this).next().slideToggle('normal');	If this breaks in IE then use this with a link
		$('#clubs ul').hide();
        $(this).next().slideToggle('normal');	
      }
    );
  }
