jQuery(document).ready(function($) {

		function updateBoxes(show,hide) {
			$(hide).stop(true, true).fadeOut(300);
			setTimeout(function() {
				if (show!=='') {
					$(show).stop(true, true).slideDown(300);
				}
			}, 301);
		}

		function checkPage() {
			// Get value of current checked option
			var current = $("select#page_template option:checked").attr("value");

			// List of all CMB IDs for this page/post
			var boxes = "#blog_options, #portfolio_options, #portfolio_messy_options, #tabs_section, #single_post_link, #coming_soon_page";

			// Update for first time
			updateBoxes("",boxes);

			// Check what to show
			if (current == 'templates/template-blog.php') {
				updateBoxes("#blog_options");
			} else if(current == 'templates/template-portfolio.php') {
				updateBoxes("#portfolio_options");
			} else if(current == 'templates/template-portfolio-fashion.php') {
				updateBoxes("#portfolio_messy_options");
			} else if(current == 'templates/template-tabs-section.php') {
				updateBoxes("#tabs_section");
			} else if(current == 'templates/template-coming-soon.php') {
				updateBoxes("#coming_soon_page");
			} else {
				updateBoxes("", boxes);
			}
		}

		function checkPost() {
			var current = $("input.post-format:checked").attr("value");
			var boxes = "#post_standard_options, #post_video_options, #post_link_options, #post_audio_options";
			updateBoxes("", boxes);
			console.log(current);

			if (current == 0) {
				updateBoxes("#post_standard_options", boxes);
			} else if(current == "video") {
				updateBoxes("#post_video_options", boxes);
			} else if(current == "link") {
				updateBoxes("#post_link_options", boxes);
			} else if(current == "audio") {
				updateBoxes("#post_audio_options", boxes);
			} else {
				updateBoxes("", boxes);
			}
		}

		// Update on Change
		$("select#page_template").change(checkPage);
		$("input.post-format").change(checkPost);

		// Update on Load
		$(window).on('load', function() {
			checkPage();
			checkPost();
		});
});