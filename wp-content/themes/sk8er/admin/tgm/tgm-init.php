<?php

/**
 * TGM Init Class
 */
include_once ('class-tgm-plugin-activation.php');

function starter_plugin_register_required_plugins() {

	$plugins = array(
		array(
			'name' 		=> 'Redux Framework',
			'slug' 		=> 'redux-framework',
			'required' 	=> true,
		),
		array(
			'name' 		=> 'Contact Form 7',
			'slug' 		=> 'contact-form-7',
			'required' 	=> false,
		),
		array(
			'name' 		=> 'WooCommerce',
			'slug' 		=> 'woocommerce',
			'required' 	=> false,
		),
		array(
			'name' 		=> 'Revolution Slider',
			'slug' 		=> 'revslider',
			'source' 		=> get_stylesheet_directory() . '/plugins/revslider.zip',
			'required' 	=> false,
		),
		array(
			'name' 		=> 'Sk8er Post Types',
			'slug' 		=> 'sk8er-posttypes',
			'source' 		=> get_stylesheet_directory() . '/plugins/sk8er-posttypes.zip',
			'required' 	=> false,
		),
		array(
			'name' 		=> 'Post Likes',
			'slug' 		=> 'post-likes',
			'source' 		=> get_stylesheet_directory() . '/plugins/post-likes.zip',
			'required' 	=> false,
		),
		array(
			'name' 		=> 'Visual Composer',
			'slug' 		=> 'js_composer',
			'source' 		=> get_stylesheet_directory() . '/plugins/js_composer.zip',
			'required' 	=> false,
		),
	);

	$config = array(
		'domain'       		=> 'redux-framework',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'plugins.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'plugins.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
	);

	tgmpa( $plugins, $config );

}
add_action( 'tgmpa_register', 'starter_plugin_register_required_plugins' );