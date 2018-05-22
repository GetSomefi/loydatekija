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
		console.log('a',a); 
		if(a == "clear"){
			sortByThese = [];
			$('.hidden-until-sorted, .beat-sorter-branch').removeClass('active');
			$('.announcements-holder').find('.one-announcement-button').removeClass('sort-hidden');
		}else{
			var exists = sortByThese.indexOf(a);
			console.log('exists', exists);

			if(exists == -1){
				sortByThese.push(a);
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
				var sortOption = $(this).data('workbranch').split(",");
				var match = false;
				var match2 = false;
				var match3 = false;

				if( $(".beat-branch-sort").find('.beat-bb').hasClass('active') ){
					for (var i = 0; i < sortOption.length; i++) {

						for (var i2 = 0; i2 < sortByThese.length; i2++) {
							if( sortOption[i] == sortByThese[i2] ){
								//$(this).removeClass('sort-hidden');
								match = true;
							}
						}
					}
				}else{
					match = true;
				}

				if( $(".beat-branch-sort").find('.beat-bs').hasClass('active') ){
					var sortOption = $(this).data('salary-type').split(",");
					for (var i = 0; i < sortOption.length; i++) {

						for (var i2 = 0; i2 < sortByThese.length; i2++) {
							if( sortOption[i] == sortByThese[i2] ){
								//$(this).removeClass('sort-hidden');
								match2 = true;
							}
						}
					}
				}else{
					match2 = true;
				}

				if( $(".beat-branch-sort").find('.beat-bt').hasClass('active') ){
					var sortOption = $(this).data('worktype').split(",");
					for (var i = 0; i < sortOption.length; i++) {

						for (var i2 = 0; i2 < sortByThese.length; i2++) {
							if( sortOption[i] == sortByThese[i2] ){
								//$(this).removeClass('sort-hidden');
								match3 = true;
							}
						}
					}
				}else{
					match3 = true;
				}
				
				if (match && match2 && match3){
					$(this).removeClass('sort-hidden');
				}

			}); 
		}	
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

		if( $(this).hasClass('beat-sorter-branch-clear') ){
			sortBy.sort = "clear";
		}else{
			if( $(this).hasClass('active') ){
				$(this).removeClass('active');
			}else{
				$(this).addClass('active');
			}			
		}
		
		sortByThis(sortBy.sort);

	});

	$('.beat-sort-hider-btn').click(function(){
		var elementId = "#" + $(this).data('hidewhat');

		if( $(this).hasClass('beat-hidden') ){
			$(this).removeClass('beat-hidden');
			$(this).html('<i class="fas fa-chevron-down"></i>');
		}else{
			$(this).addClass('beat-hidden');
			$(this).html('<i class="fas fa-chevron-up"></i>');
		}

		if( $(elementId).hasClass('beat-hidden') ){
			$(elementId).removeClass('beat-hidden');
			$(elementId).slideDown();
		}else{
			$(elementId).addClass('beat-hidden');
			$(elementId).slideUp();
		}
	});
	  	
	/*search from content*/
	function searchFromContent(){
		$('.beat-no-matches, .beat-yes-matches').remove();
		var txt = $('#beat-filter-search').val();
		if(txt == ""){
			$('.one-announcement').removeClass('not-a-match').removeClass('this-is-a-match');
			$('.this-is-a-match-parent').removeClass('this-is-a-match-parent');
		}else{
			txt = txt.toLowerCase();
			$('.one-announcement').each(function(){
				var elementId = "#" + $(this).data('contentid');

				elementAsText = $(elementId).find('.beat-searchable-content').text();
				elementAsText = elementAsText.toLowerCase();
				console.log('text', elementAsText );
				if (elementAsText.indexOf(txt) >= 0){
					$(this).addClass('this-is-a-match');
					$(this).removeClass('not-a-match');

					$(this).parents('.one-announcement-button').addClass('this-is-a-match-parent').prependTo('.announcements-holder');
				}else{
					$(this).removeClass('this-is-a-match');
					$(this).addClass('not-a-match');

					$(this).parents('.one-announcement-button').removeClass('this-is-a-match-parent');
				}
			});

			

			$('.this-is-a-match-parent').first().before("<div class='beat-yes-matches'><h3>Sisältää hakusanan <b>"+$('#beat-filter-search').val()+"</b></h3></div>");
			$('.this-is-a-match-parent').last().after("<div class='beat-no-matches'><h3>Ei sisällä hakusanaa</h3></div>");
		}
	}  	
	$('#beat-filter-search').keyup(function(){
		searchFromContent();
	});
	$('.beat-filter-search-submit').click(function(e){
		var hash = "#all-jobs-list";
		console.log('juu'); 
		$('html, body').animate({
			scrollTop: $(hash).offset().top
			}, 300, function(){
			console.log('juu2'); 
			//window.location.hash = hash;
		});	
		searchFromContent();
	});
	  	
});     
}(jQuery));
