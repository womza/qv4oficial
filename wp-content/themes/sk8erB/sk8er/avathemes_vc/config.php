<?php
/**
 * Laborator Visual Composer Settings
 *
 */

/* ! Layout Elements */
$curr_dir = dirname(__FILE__);

//////////////////////////////////////////
// Remove some of the defaults elements //
//////////////////////////////////////////
$vc_is_wp_version_3_6_more = version_compare(preg_replace('/^([\d\.]+)(\-.*$)/', '$1', get_bloginfo('version')), '3.6') >= 0;

/* Register Own Param Types */
vc_remove_element("vc_wp_rss");
vc_remove_element("vc_wp_archives");
vc_remove_element("vc_wp_categories");
vc_remove_element("vc_wp_posts");
vc_remove_element("vc_wp_text");
vc_remove_element("vc_wp_custommenu");
vc_remove_element("vc_wp_tagcloud");
vc_remove_element("vc_wp_pages");
vc_remove_element("vc_wp_calendar");
vc_remove_element("vc_wp_recentcomments");
vc_remove_element("vc_wp_meta");
vc_remove_element("vc_wp_search");

/* Shortcodes */
add_action('init', 'avathemes_vc_shortcodes');

function avathemes_vc_shortcodes()
{
	global $curr_dir;

	include_once($curr_dir . '/shortcodes/vc_svg_block.php');

	include_once($curr_dir . '/shortcodes/vc_pure_text.php');
	include_once($curr_dir . '/shortcodes/vc_s1_textwithimage.php');
	include_once($curr_dir . '/shortcodes/vc_s1_bigquote.php');

	include_once($curr_dir . '/shortcodes/vc_s1_our_services.php');
	include_once($curr_dir . '/shortcodes/vc_s18_our_services.php');

	include_once($curr_dir . '/shortcodes/vc_s1_portfolio_posts.php');
	include_once($curr_dir . '/shortcodes/vc_s2_portfolio_posts.php');
	include_once($curr_dir . '/shortcodes/vc_s4_portfolio_posts.php');
	include_once($curr_dir . '/shortcodes/vc_s10_portfolio_posts.php');
	include_once($curr_dir . '/shortcodes/vc_s17_portfolio_posts.php');

	include_once($curr_dir . '/shortcodes/vc_s1_latest_news.php');
	include_once($curr_dir . '/shortcodes/vc_s2_latest_news.php');
	include_once($curr_dir . '/shortcodes/vc_s5_latest_news_with_quote.php');
	include_once($curr_dir . '/shortcodes/vc_s10_latest_news.php');
	include_once($curr_dir . '/shortcodes/vc_s12_latest_news.php');
	include_once($curr_dir . '/shortcodes/vc_s18_latest_news.php');

	include_once($curr_dir . '/shortcodes/vc_s1_fun_facts.php');
	include_once($curr_dir . '/shortcodes/vc_s1_big_testimonials.php');
	include_once($curr_dir . '/shortcodes/vc_s2_links.php');
	include_once($curr_dir . '/shortcodes/vc_s2_portfolio_posts_bigblocks.php');

	include_once($curr_dir . '/shortcodes/vc_s2_members.php');
	// include_once($curr_dir . '/shortcodes/vc_s3_members.php');

	include_once($curr_dir . '/shortcodes/vc_s2_image_details.php');
	include_once($curr_dir . '/shortcodes/vc_s3_products_table.php');
	include_once($curr_dir . '/shortcodes/vc_s3_star_features.php');
	include_once($curr_dir . '/shortcodes/vc_s3_testimonials.php');
	include_once($curr_dir . '/shortcodes/vc_s4_events.php');
	include_once($curr_dir . '/shortcodes/vc_s4_about.php');
	include_once($curr_dir . '/shortcodes/vc_s4_soundcloud.php');
	include_once($curr_dir . '/shortcodes/vc_big_contact.php');
	include_once($curr_dir . '/shortcodes/vc_s6_about_block.php');
	include_once($curr_dir . '/shortcodes/vc_s6_grid_products_list.php');

	include_once($curr_dir . '/shortcodes/vc_s7_steps.php');
	include_once($curr_dir . '/shortcodes/vc_s16_steps.php');
	include_once($curr_dir . '/shortcodes/vc_steps_v3.php');

	include_once($curr_dir . '/shortcodes/vc_s7_posts_item_list.php');
	include_once($curr_dir . '/shortcodes/vc_s7_video.php');
	include_once($curr_dir . '/shortcodes/vc_s8_head_text.php');
	include_once($curr_dir . '/shortcodes/vc_s8_portfolio_categories.php');
	include_once($curr_dir . '/shortcodes/vc_s9_wine_tabs.php');
	include_once($curr_dir . '/shortcodes/vc_s9_wine_posts.php');
	include_once($curr_dir . '/shortcodes/vc_s9_single_wine.php');
	include_once($curr_dir . '/shortcodes/vc_s9_benefits.php');
	include_once($curr_dir . '/shortcodes/vc_s9_social_networks.php');
	include_once($curr_dir . '/shortcodes/vc_s10_about_with_image.php');
	include_once($curr_dir . '/shortcodes/vc_s10_text_with_link.php');
	include_once($curr_dir . '/shortcodes/vc_s10_mockup_slider.php');
	include_once($curr_dir . '/shortcodes/vc_s11_text_quote_images.php');
	include_once($curr_dir . '/shortcodes/vc_s11_products_with_testimonials.php');
	include_once($curr_dir . '/shortcodes/vc_s11_process.php');
	include_once($curr_dir . '/shortcodes/vc_s13_subscribe.php');
	include_once($curr_dir . '/shortcodes/vc_s16_small_galleries.php');
	include_once($curr_dir . '/shortcodes/vc_s16_info_and_location.php');
	include_once($curr_dir . '/shortcodes/vc_s18_about_with_slider.php');
	include_once($curr_dir . '/shortcodes/vc_s18_lists_and_faq.php');
	include_once($curr_dir . '/shortcodes/vc_s18_minimal_info.php');
	include_once($curr_dir . '/shortcodes/vc_s18_info_block.php');

	include_once($curr_dir . '/shortcodes/vc_google_map.php');
	include_once($curr_dir . '/shortcodes/vc_detailed_info.php');
	include_once($curr_dir . '/shortcodes/vc_contact_form.php');
	include_once($curr_dir . '/shortcodes/vc_clients.php');
	include_once($curr_dir . '/shortcodes/vc_text_with_image.php');
	include_once($curr_dir . '/shortcodes/vc_image_bottom.php');
	include_once($curr_dir . '/shortcodes/vc_standalone_image.php');
	include_once($curr_dir . '/shortcodes/vc_list_with_image.php');
	include_once($curr_dir . '/shortcodes/vc_text_with_images.php');
	include_once($curr_dir . '/shortcodes/vc_features.php');
	include_once($curr_dir . '/shortcodes/vc_text_with_image_v3.php');
	include_once($curr_dir . '/shortcodes/vc_listed_items.php');
	include_once($curr_dir . '/shortcodes/vc_pricing_packages.php');
	include_once($curr_dir . '/shortcodes/vc_text_block.php');
	include_once($curr_dir . '/shortcodes/vc_faq_block.php');
	include_once($curr_dir . '/shortcodes/vc_text_button_strip.php');

	include_once($curr_dir . '/shortcodes/vc_shop_items.php');

	include_once($curr_dir . '/shortcodes/vc_image_links.php');


	//if(in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option( 'active_plugins'))))
	//{
	//	include_once($curr_dir . '/shortcodes/vc_products.php');
	//}
}

/* Admin Styles */
add_action('admin_enqueue_scripts', 'avathemes_vc_styles', 50);
function avathemes_vc_styles()
{
	wp_enqueue_style('avathemes_vc_backend', get_template_directory_uri().'/avathemes_vc/assets/avathemes_vc_main.css', array(), '1.0', 'all' );
}

/* Frontend Styles */
add_action('wp_enqueue_scripts', 'avathemes_vc_styles_frontend', 50);
function avathemes_vc_styles_frontend()
{
	wp_enqueue_style('avathemes_vc_frontend', get_template_directory_uri().'/avathemes_vc/assets/frontend_vc.css', array(), '1.0', 'all' );
}