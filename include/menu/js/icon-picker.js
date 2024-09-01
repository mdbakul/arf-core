(function ($) {
  "use strict";
	
	$(document).ready(function() {
		
		$(document).on('click', 'input.shofyicon-picker', function(event){
			event.preventDefault(); 
			$(this).closest('.shofy-field-iconfield').find('.shofy-iconsholder-wrapper').slideToggle();
		});
		
		
		$(document).on('click', '.shofy-iconbox', function(event){	
			$(this).closest('.shofy-field-iconfield').find('input.shofyicon-picker').val($(this).find('i').attr('class'));
			$(this).closest('.shofy-field-iconfield').find('.shofy-iconsholder-wrapper').slideToggle();
		});
		
		
		var shofyicon = 'shofyicon-store shofyicon-magnifying-glass shofyicon-search shofyicon-heart shofyicon-user shofyicon-menu shofyicon-menu-1 shofyicon-watermelon shofyicon-broccoli shofyicon-cupcake shofyicon-bread shofyicon-apple shofyicon-fish shofyicon-snack shofyicon-eggs shofyicon-coffee shofyicon-pet shofyicon-basketball-match shofyicon-milk shofyicon-vegan shofyicon-smartphone shofyicon-camera shofyicon-monitor shofyicon-home shofyicon-store-1 shofyicon-gift shofyicon-discount shofyicon-voucher shofyicon-price-tag shofyicon-football shofyicon-running shofyicon-play-button',
			
		shofyiconArray = shofyicon.split(' '); // creating array

		// This loop will add icons inside BOX
		for (var i = 0; i < shofyiconArray.length; i++) {
			jQuery(".shofy-iconsholder").append('<div class="shofy-iconbox"><p class="icon"><i class="' + shofyiconArray[i] + '"></i>'+shofyiconArray[i]+'</p></div>');
		}

		var timeout;
		$("input.iconsearch").on("keyup", function() {
			if(timeout) {
				clearTimeout(timeout);
			}
			
			var value = this.value.toLowerCase().trim();
			var iconbox = $(this).closest('.shofy-field-iconfield').find('.shofy-iconbox');
			timeout = setTimeout(function() {
			  $(iconbox).show().filter(function() {
				return $(this).text().toLowerCase().trim().indexOf(value) == -1;
			  }).hide();
			}, 500);
		});

	});

})(jQuery);
