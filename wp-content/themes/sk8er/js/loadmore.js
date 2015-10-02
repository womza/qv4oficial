(function($){
	$(window).on('load', function() {
		$('.load_more:not(.loading)').on('click',function(e){
			e.preventDefault();
			var $load_more_btn = $(this);
			var post_type = 'portfolio'; // this is optional and can be set from anywhere, stored in mockup etc...
			var offset = $('.portfolio-items-wrapper .item').length;
			var nonce = $load_more_btn.attr('data-nonce');
			$.ajax({
		        	type : "post",
		        	context: this,
		         	dataType : "json",
		         	url : headJS.ajaxurl,
					data : {action: "load_more", offset:offset, nonce:nonce, post_type:post_type, posts_per_page:headJS.posts_per_page},
		         	beforeSend: function(data) {
						// here u can do some loading animation...
						$load_more_btn.addClass('loading').html('<span>Cargando...</span>');// good for styling and also to prevent ajax calls before content is loaded by adding loading class
		         	},
		         	success: function(response) {
						if (response['have_posts'] == 1){//if have posts:
							$load_more_btn.removeClass('loading').html('<span>Cargar m&aacute;s</span>');
							var $newElems = $(response['html'].replace(/(\r\n|\n|\r)/gm, ''));// here removing extra breaklines and spaces
							$('.portfolio-items-wrapper').append($newElems);

							$(".style-15.portfolio-items.grid .item").each(function() {
							  var height = $(this).find(".info").outerHeight();

							  $(this).find(".image, .info").css({
							    "min-height": 0,
							    "height"    : height,
							    "max-height": height,
							  });
							});

							$('.portfolio-items-wrapper').find(".item:odd").addClass("highlight");

							$('.portfolio-items-wrapper').isotope('appended', $newElems);

							$(".portfolio-filter li a.filter:not(.all)").each(function() {
							  var jthis = this;
							  var data = $(this).data("filter");

							  if ($(data).length) {
							    $(jthis).fadeIn();
							    console.log("EXIST");
							    }
							});
						} else {
							//end of posts (no posts found)
							$load_more_btn.removeClass('loading').addClass('end_of_posts').html('<span>Fin de Post</span>'); // change buttom styles if no more posts
						}
		         	}
		      	});
		})
	});
})(jQuery); 