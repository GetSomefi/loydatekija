(function($) {
	$(document).ready(function(){

		//smooth scroll
		$("a[href^='#']").on('click', function(e) {
			e.preventDefault();
			var hash = this.hash;
			$('html, body').animate({
				scrollTop: $(hash).offset().top
				}, 300, function(){
				window.location.hash = hash;
			});
		});

		$(".entry-header").appendTo( $(".um-page-user").find(".um-profile .um-cover-e") );
	});
}(jQuery));
