<?php



/*



Plugin Name: Sk8er Post Types



Plugin URI: #



Description: Add Custom Post Types for this theme



Version: 1.0



Author: AvaThemes



Author URI: http://themeforest.net/user/AVAThemes



*/







/* PORTFOLIO */



add_action( 'init', 'sk8er_portfolio_posttype', 0 );



function sk8er_portfolio_posttype() {







	$labels = array(



		'name'                => _x( 'Projects', 'Post Type General Name', 'sk8er' ),



		'singular_name'       => _x( 'Project', 'Post Type Singular Name', 'sk8er' ),



		'menu_name'           => __( 'Portfolio', 'sk8er' ),



		'parent_item_colon'   => __( 'Parent Project:', 'sk8er' ),



		'all_items'           => __( 'All Projects', 'sk8er' ),



		'view_item'           => __( 'View Project', 'sk8er' ),



		'add_new_item'        => __( 'Add New Project', 'sk8er' ),



		'add_new'             => __( 'Add New', 'sk8er' ),



		'edit_item'           => __( 'Edit Project', 'sk8er' ),



		'update_item'         => __( 'Update Project', 'sk8er' ),



		'search_items'        => __( 'Search Project', 'sk8er' ),



		'not_found'           => __( 'Not found', 'sk8er' ),



		'not_found_in_trash'  => __( 'Not found in Trash', 'sk8er' ),



	);



	$args = array(



		'label'               => __( 'portfolio', 'sk8er' ),



		'description'         => __( 'Portfolio Post Type', 'sk8er' ),



		'labels'              => $labels,



		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),



		'hierarchical'        => false,



		'public'              => true,



		'show_ui'             => true,



		'show_in_menu'        => true,



		'show_in_nav_menus'   => true,



		'show_in_admin_bar'   => true,



		'menu_position'       => 5,



		'menu_icon'           => 'dashicons-welcome-widgets-menus',



		'can_export'          => true,



		'has_archive'         => true,



		'exclude_from_search' => false,



		'publicly_queryable'  => true,



		'capability_type'     => 'page',

		

		'taxonomies' => array('post_tag'),



	);



	register_post_type( 'portfolio', $args );



}



add_action( 'init', 'sk8er_portfolio_taxonomy', 0 );



function sk8er_portfolio_taxonomy() {







	$labels = array(



		'name'                       => _x( 'Categories', 'Taxonomy General Name', 'sk8er' ),



		'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'sk8er' ),



		'menu_name'                  => __( 'Categories', 'sk8er' ),



		'all_items'                  => __( 'All Categories', 'sk8er' ),



		'parent_item'                => __( 'Parent Category', 'sk8er' ),



		'parent_item_colon'          => __( 'Parent Category:', 'sk8er' ),



		'new_item_name'              => __( 'New Category Name', 'sk8er' ),



		'add_new_item'               => __( 'Add New Category', 'sk8er' ),



		'edit_item'                  => __( 'Edit Category', 'sk8er' ),



		'update_item'                => __( 'Update Category', 'sk8er' ),



		'separate_items_with_commas' => __( 'Separate Categories with commas', 'sk8er' ),



		'search_items'               => __( 'Search Categories', 'sk8er' ),



		'add_or_remove_items'        => __( 'Add or remove Categories', 'sk8er' ),



		'choose_from_most_used'      => __( 'Choose from the most used Categories', 'sk8er' ),



		'not_found'                  => __( 'Not Found', 'sk8er' ),



	);



	$args = array(



		'labels'                     => $labels,



		'hierarchical'               => true,



		'public'                     => true,



		'show_ui'                    => true,



		'show_admin_column'          => true,



		'show_in_nav_menus'          => true,



		'show_tagcloud'              => true,



	);



	register_taxonomy( 'portfolio-categories', array( 'portfolio' ), $args );



}



/* MEMBERS */



	// Register Custom Post Type

	function sk8er_members() {



		$labels = array(

			'name'                => _x( 'Members', 'Post Type General Name', 'sk8er' ),

			'singular_name'       => _x( 'Member', 'Post Type Singular Name', 'sk8er' ),

			'menu_name'           => __( 'Members', 'sk8er' ),

			'parent_item_colon'   => __( 'Parent Member:', 'sk8er' ),

			'all_items'           => __( 'All Members', 'sk8er' ),

			'view_item'           => __( 'View Member', 'sk8er' ),

			'add_new_item'        => __( 'Add New Member', 'sk8er' ),

			'add_new'             => __( 'Add New', 'sk8er' ),

			'edit_item'           => __( 'Edit Item', 'sk8er' ),

			'update_item'         => __( 'Update Item', 'sk8er' ),

			'search_items'        => __( 'Search Item', 'sk8er' ),

			'not_found'           => __( 'Not found', 'sk8er' ),

			'not_found_in_trash'  => __( 'Not found in Trash', 'sk8er' ),

		);

		$args = array(

			'label'               => __( 'members', 'sk8er' ),

			'description'         => __( 'Members', 'sk8er' ),

			'labels'              => $labels,

			'supports'            => array( 'title', 'editor', 'thumbnail', ),

			'hierarchical'        => false,

			'public'              => true,

			'show_ui'             => true,

			'show_in_menu'        => true,

			'show_in_nav_menus'   => true,

			'show_in_admin_bar'   => true,

			'menu_position'       => 5,

			'can_export'          => true,

			'has_archive'         => false,

			'exclude_from_search' => true,

			'publicly_queryable'  => true,

			'capability_type'     => 'page',

			'menu_icon'           => 'dashicons-groups',



		);

		register_post_type( 'members', $args );



	}



	// Hook into the 'init' action

	add_action( 'init', 'sk8er_members', 0 );



/* EVENTS */



	// Register Custom Post Type

	function sk8er_events() {



		$labels = array(

			'name'                => _x( 'Events', 'Post Type General Name', 'sk8er' ),

			'singular_name'       => _x( 'Event', 'Post Type Singular Name', 'sk8er' ),

			'menu_name'           => __( 'Events', 'sk8er' ),

			'parent_item_colon'   => __( 'Parent Event:', 'sk8er' ),

			'all_items'           => __( 'All Events', 'sk8er' ),

			'view_item'           => __( 'View Event', 'sk8er' ),

			'add_new_item'        => __( 'Add New Event', 'sk8er' ),

			'add_new'             => __( 'Add New', 'sk8er' ),

			'edit_item'           => __( 'Edit Item', 'sk8er' ),

			'update_item'         => __( 'Update Item', 'sk8er' ),

			'search_items'        => __( 'Search Item', 'sk8er' ),

			'not_found'           => __( 'Not found', 'sk8er' ),

			'not_found_in_trash'  => __( 'Not found in Trash', 'sk8er' ),

		);

		$args = array(

			'label'               => __( 'events', 'sk8er' ),

			'description'         => __( 'Events', 'sk8er' ),

			'labels'              => $labels,

			'supports'            => array( 'title', 'editor', 'thumbnail', ),

			'hierarchical'        => false,

			'public'              => true,

			'show_ui'             => true,

			'show_in_menu'        => true,

			'show_in_nav_menus'   => true,

			'show_in_admin_bar'   => true,

			'menu_position'       => 5,

			'can_export'          => true,

			'has_archive'         => false,

			'exclude_from_search' => true,

			'publicly_queryable'  => true,

			'capability_type'     => 'page',

			'menu_icon'           => 'dashicons-awards',



		);

		register_post_type( 'events', $args );



	}



	// Hook into the 'init' action

	add_action( 'init', 'sk8er_events', 0 );



/* Wines */



	// Register Custom Post Type

	function sk8er_wines() {



		$labels = array(

			'name'                => _x( 'Wines', 'Post Type General Name', 'sk8er' ),

			'singular_name'       => _x( 'Wine', 'Post Type Singular Name', 'sk8er' ),

			'menu_name'           => __( 'Wines', 'sk8er' ),

			'parent_item_colon'   => __( 'Parent Wine:', 'sk8er' ),

			'all_items'           => __( 'All Wines', 'sk8er' ),

			'view_item'           => __( 'View Wine', 'sk8er' ),

			'add_new_item'        => __( 'Add New Wine', 'sk8er' ),

			'add_new'             => __( 'Add New', 'sk8er' ),

			'edit_item'           => __( 'Edit Item', 'sk8er' ),

			'update_item'         => __( 'Update Item', 'sk8er' ),

			'search_items'        => __( 'Search Item', 'sk8er' ),

			'not_found'           => __( 'Not found', 'sk8er' ),

			'not_found_in_trash'  => __( 'Not found in Trash', 'sk8er' ),

		);

		$args = array(

			'label'               => __( 'wines', 'sk8er' ),

			'description'         => __( 'Wines', 'sk8er' ),

			'labels'              => $labels,

			'supports'            => array( 'title', 'editor', 'thumbnail', ),

			'hierarchical'        => false,

			'public'              => true,

			'show_ui'             => true,

			'show_in_menu'        => true,

			'show_in_nav_menus'   => true,

			'show_in_admin_bar'   => true,

			'menu_position'       => 5,

			'can_export'          => true,

			'has_archive'         => false,

			'exclude_from_search' => true,

			'publicly_queryable'  => true,

			'capability_type'     => 'page',

			'menu_icon'           => 'dashicons-smiley',



		);

		register_post_type( 'wines', $args );



	}



	// Hook into the 'init' action

	add_action( 'init', 'sk8er_wines', 0 );



/* Services */



	// Register Custom Post Type

	function sk8er_services() {



		$labels = array(

			'name'                => _x( 'Services', 'Post Type General Name', 'sk8er' ),

			'singular_name'       => _x( 'Service', 'Post Type Singular Name', 'sk8er' ),

			'menu_name'           => __( 'Services', 'sk8er' ),

			'parent_item_colon'   => __( 'Parent Service:', 'sk8er' ),

			'all_items'           => __( 'All Services', 'sk8er' ),

			'view_item'           => __( 'View Service', 'sk8er' ),

			'add_new_item'        => __( 'Add New Service', 'sk8er' ),

			'add_new'             => __( 'Add New', 'sk8er' ),

			'edit_item'           => __( 'Edit Item', 'sk8er' ),

			'update_item'         => __( 'Update Item', 'sk8er' ),

			'search_items'        => __( 'Search Item', 'sk8er' ),

			'not_found'           => __( 'Not found', 'sk8er' ),

			'not_found_in_trash'  => __( 'Not found in Trash', 'sk8er' ),

		);

		$args = array(

			'label'               => __( 'services', 'sk8er' ),

			'description'         => __( 'Services', 'sk8er' ),

			'labels'              => $labels,

			'supports'            => array( 'title', 'editor', 'thumbnail', ),

			'hierarchical'        => false,

			'public'              => true,

			'show_ui'             => true,

			'show_in_menu'        => true,

			'show_in_nav_menus'   => true,

			'show_in_admin_bar'   => true,

			'menu_position'       => 5,

			'can_export'          => true,

			'has_archive'         => false,

			'exclude_from_search' => true,

			'publicly_queryable'  => true,

			'capability_type'     => 'page',

			'menu_icon'           => 'dashicons-hammer',



		);

		register_post_type( 'services', $args );



	}



	// Hook into the 'init' action

	add_action( 'init', 'sk8er_services', 0 );





/* Shop News */



	// Register Custom Post Type

	function sk8er_shop_news() {



		$labels = array(

			'name'                => _x( 'Shop News', 'Post Type General Name', 'sk8er' ),

			'singular_name'       => _x( 'Shop News', 'Post Type Singular Name', 'sk8er' ),

			'menu_name'           => __( 'Shop News', 'sk8er' ),

			'parent_item_colon'   => __( 'Parent Shop News:', 'sk8er' ),

			'all_items'           => __( 'All Shop News', 'sk8er' ),

			'view_item'           => __( 'View Shop News', 'sk8er' ),

			'add_new_item'        => __( 'Add New Shop News', 'sk8er' ),

			'add_new'             => __( 'Add New', 'sk8er' ),

			'edit_item'           => __( 'Edit Item', 'sk8er' ),

			'update_item'         => __( 'Update Item', 'sk8er' ),

			'search_items'        => __( 'Search Item', 'sk8er' ),

			'not_found'           => __( 'Not found', 'sk8er' ),

			'not_found_in_trash'  => __( 'Not found in Trash', 'sk8er' ),

		);

		$args = array(

			'label'               => __( 'shopnews', 'sk8er' ),

			'description'         => __( 'Shop News', 'sk8er' ),

			'labels'              => $labels,

			'supports'            => array( 'title', 'editor', 'thumbnail', ),

			'hierarchical'        => false,

			'public'              => true,

			'show_ui'             => true,

			'show_in_menu'        => true,

			'show_in_nav_menus'   => true,

			'show_in_admin_bar'   => true,

			'menu_position'       => 5,

			'can_export'          => true,

			'has_archive'         => false,

			'exclude_from_search' => true,

			'publicly_queryable'  => true,

			'capability_type'     => 'page',

			'menu_icon'           => 'dashicons-cart',



		);

		register_post_type( 'shop_news', $args );



	}



	// Hook into the 'init' action

	add_action( 'init', 'sk8er_shop_news', 0 );



/* Pricing Packages*/



	// Register Custom Post Type

	function sk8er_pricing_packages() {



		$labels = array(

			'name'                => _x( 'Pricing Packages', 'Post Type General Name', 'sk8er' ),

			'singular_name'       => _x( 'Pricing Packages', 'Post Type Singular Name', 'sk8er' ),

			'menu_name'           => __( 'Pricing Packages', 'sk8er' ),

			'parent_item_colon'   => __( 'Parent Package:', 'sk8er' ),

			'all_items'           => __( 'All Pricing Packages', 'sk8er' ),

			'view_item'           => __( 'View Pricing Packages', 'sk8er' ),

			'add_new_item'        => __( 'Add New Pricing Packages', 'sk8er' ),

			'add_new'             => __( 'Add New', 'sk8er' ),

			'edit_item'           => __( 'Edit Item', 'sk8er' ),

			'update_item'         => __( 'Update Item', 'sk8er' ),

			'search_items'        => __( 'Search Item', 'sk8er' ),

			'not_found'           => __( 'Not found', 'sk8er' ),

			'not_found_in_trash'  => __( 'Not found in Trash', 'sk8er' ),

		);

		$args = array(

			'label'               => __( 'pricingpackages', 'sk8er' ),

			'description'         => __( 'Pricing Packages', 'sk8er' ),

			'labels'              => $labels,

			'supports'            => array( 'title', 'editor', 'thumbnail', ),

			'hierarchical'        => false,

			'public'              => true,

			'show_ui'             => true,

			'show_in_menu'        => true,

			'show_in_nav_menus'   => true,

			'show_in_admin_bar'   => true,

			'menu_position'       => 5,

			'can_export'          => true,

			'has_archive'         => false,

			'exclude_from_search' => true,

			'publicly_queryable'  => true,

			'capability_type'     => 'page',

			'menu_icon'           => 'dashicons-tag',



		);

		register_post_type( 'pricing_packages', $args );



	}



	// Hook into the 'init' action

	add_action( 'init', 'sk8er_pricing_packages', 0 );



/* Fun Facts */



		// Register Custom Post Type

		function sk8er_fun_facts() {



			$labels = array(

				'name'                => _x( 'Fun Facts', 'Post Type General Name', 'sk8er' ),

				'singular_name'       => _x( 'Fun Facts', 'Post Type Singular Name', 'sk8er' ),

				'menu_name'           => __( 'Fun Facts', 'sk8er' ),

				'parent_item_colon'   => __( 'Parent Fact:', 'sk8er' ),

				'all_items'           => __( 'All Fun Facts', 'sk8er' ),

				'view_item'           => __( 'View Fun Facts', 'sk8er' ),

				'add_new_item'        => __( 'Add New Fun Facts', 'sk8er' ),

				'add_new'             => __( 'Add New', 'sk8er' ),

				'edit_item'           => __( 'Edit Item', 'sk8er' ),

				'update_item'         => __( 'Update Item', 'sk8er' ),

				'search_items'        => __( 'Search Item', 'sk8er' ),

				'not_found'           => __( 'Not found', 'sk8er' ),

				'not_found_in_trash'  => __( 'Not found in Trash', 'sk8er' ),

			);

			$args = array(

				'label'               => __( 'funfacts', 'sk8er' ),

				'description'         => __( 'Fun Facts', 'sk8er' ),

				'labels'              => $labels,

				'supports'            => array( 'title', 'editor', 'thumbnail', ),

				'hierarchical'        => false,

				'public'              => true,

				'show_ui'             => true,

				'show_in_menu'        => true,

				'show_in_nav_menus'   => true,

				'show_in_admin_bar'   => true,

				'menu_position'       => 5,

				'can_export'          => true,

				'has_archive'         => false,

				'exclude_from_search' => true,

				'publicly_queryable'  => true,

				'capability_type'     => 'page',

				'menu_icon'           => 'dashicons-universal-access',



			);

			register_post_type( 'fun_facts', $args );



		}



		// Hook into the 'init' action

		add_action( 'init', 'sk8er_fun_facts', 0 );



/* Page Links */



		// Register Custom Post Type

		function sk8er_page_links() {



			$labels = array(

				'name'                => _x( 'Page Links', 'Post Type General Name', 'sk8er' ),

				'singular_name'       => _x( 'Page Links', 'Post Type Singular Name', 'sk8er' ),

				'menu_name'           => __( 'Page Links', 'sk8er' ),

				'parent_item_colon'   => __( 'Parent Page Link:', 'sk8er' ),

				'all_items'           => __( 'All Page Links', 'sk8er' ),

				'view_item'           => __( 'View Page Links', 'sk8er' ),

				'add_new_item'        => __( 'Add New Page Links', 'sk8er' ),

				'add_new'             => __( 'Add New', 'sk8er' ),

				'edit_item'           => __( 'Edit Item', 'sk8er' ),

				'update_item'         => __( 'Update Item', 'sk8er' ),

				'search_items'        => __( 'Search Item', 'sk8er' ),

				'not_found'           => __( 'Not found', 'sk8er' ),

				'not_found_in_trash'  => __( 'Not found in Trash', 'sk8er' ),

			);

			$args = array(

				'label'               => __( 'pagelinks', 'sk8er' ),

				'description'         => __( 'Page Links', 'sk8er' ),

				'labels'              => $labels,

				'supports'            => array( 'title', 'editor', 'thumbnail', ),

				'hierarchical'        => false,

				'public'              => true,

				'show_ui'             => true,

				'show_in_menu'        => true,

				'show_in_nav_menus'   => true,

				'show_in_admin_bar'   => true,

				'menu_position'       => 5,

				'can_export'          => true,

				'has_archive'         => false,

				'exclude_from_search' => true,

				'publicly_queryable'  => true,

				'capability_type'     => 'page',

				'menu_icon'           => 'dashicons-admin-links',



			);

			register_post_type( 'page_links', $args );



		}



		// Hook into the 'init' action

		add_action( 'init', 'sk8er_page_links', 0 );