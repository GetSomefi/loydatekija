(function($) {
$(document).ready(function(){
	//smooth scroll
	$("a.smooth-scroll").on('click', function(e) {
		e.preventDefault();
		var hash = this.hash;
		$('html, body').animate({
			scrollTop: $(hash).offset().top
			}, 300, function(){
			window.location.hash = hash;
		});			
	});

	$(".entry-header").appendTo( $(".um-page-user").find(".um-profile .um-cover-e") );


	var sortByThese = [];
	function sortByThis(a){
		var exists = sortByThese.indexOf(a);
		console.log('exists', exists);

		if(exists == -1){
			sortByThese.push(a);
			//$('.announcements-holder').find('.one-announcement-button').removeClass('sort-hidden');
		}else{
			sortByThese.splice(exists,1);
		}

		if(sortByThese.length != 0 ){
			$('.announcements-holder').find('.one-announcement-button').addClass('sort-hidden');
			$('.hidden-until-sorted').addClass('active');	
		}else{
			$('.announcements-holder').find('.one-announcement-button').removeClass('sort-hidden');
			$('.hidden-until-sorted').removeClass('active');
		}

		$('.announcements-holder').find('.one-announcement-button').each(function( i ){
			var workbranches = $(this).data('workbranch').split(",");
			var match = false;
			for (var i = 0; i < workbranches.length; i++) {

				for (var i2 = 0; i2 < sortByThese.length; i2++) {
					if( workbranches[i] == sortByThese[i2] ){
						match = true;
						$(this).removeClass('sort-hidden');
					}
				}

			}
		  
		});  
	}


	/*close all open ones (also on sorting)*/
	$('.one-announcement, .beat-sorter-branch').click( function(e) {
		$('.collapse').collapse('hide');
	});

	/*close the open one*/
	$('button.close-announcement').click(function(){
		$(this).parent().collapse('hide');
	});

	$('.beat-sorter-branch').click(function(){
		var sortBy = $(this).data();
		sortByThis(sortBy.sort);
		//console.log('Sort',sortBy.sort); 

		//FIKSAA!
		if( $(this).hasClass('active') ){
			$(this).removeClass('active');
		}else{
			$(this).addClass('active');
		}

	});
	});     
}(jQuery));
