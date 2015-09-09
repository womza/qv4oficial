<?php
/**
 * Include and setup custom metaboxes and fields.
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

add_filter( 'cmb_meta_boxes', 'cmb_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb_sample_metaboxes( array $meta_boxes ) {

	// Start with an underscore to hide fields from custom fields list
	$prefix = 'sk8er_';

	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$meta_boxes['page_options'] = array(
		'id'         => 'page_options',
		'title'      => __( 'Page Revolution Slider', 'sk8ter' ),
		'description'=> __( 'Some pages may not display this revolution slider.', 'sk8er' ),
		'pages'      => array( 'page', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
			    'name' => 'Revolution Slider Shortcode',
			    'desc' => '',
			    'id' => $prefix . 'page_revolution_slider',
			    'type' => 'text_medium'
			),
		),
	);

	$meta_boxes['pagelinks_option'] = array(
		'id'         => 'pagelinks_options',
		'title'      => __( 'Page Link options', 'sk8ter' ),
		'description'=> __( '', 'sk8er' ),
		'pages'      => array( 'page_links', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
			    'name' => 'URL',
			    'desc' => '',
			    'id' => $prefix . 'pagelink_url',
			    'type' => 'text_medium'
			),
		),
	);

	$meta_boxes['blog_options'] = array(
		'id'         => 'blog_options',
		'title'      => __( 'Blog options', 'sk8ter' ),
		'pages'      => array( 'page', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
				'name'    => __( 'Blog Columns', 'sk8ter' ),
				'desc'    => __( 'Select how much columns should be on Blog Page.', 'sk8ter' ),
				'id'      => $prefix . 'blog_columns',
				'type'    => 'select',
				'options' => array(
					'1' 	=> __( '1', 'sk8ter' ),
					'2'   	=> __( '2', 'sk8ter' ),
					'3'     => __( '3', 'sk8ter' ),
				),
			),
			array(
				'name'    => __( 'Layout', 'sk8ter' ),
				'desc'    => __( 'In what Layout should posts be. Blog Columns doesn\'t affect on Grid Layout.', 'sk8ter' ),
				'id'      => $prefix . 'blog_layout',
				'type'    => 'select',
				'options' => array(
					'normal' 				=> __( 'Normal', 'sk8ter' ),
					'grid'   				=> __( 'Grid', 'sk8ter' ),
				),
			),
			array(
				'name' => __( 'Show Sidebar', 'sk8er' ),
				'desc' => __( '', 'sk8er' ),
				'id' => $prefix . 'blog_sidebar',
				'type' => 'checkbox',
			),
		),
	);

	$meta_boxes['portfolio_options'] = array(
		'id'         => 'portfolio_options',
		'title'      => __( 'Portfolio options', 'sk8ter' ),
		'pages'      => array( 'page', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
				'name'    => __( 'Columns', 'sk8ter' ),
				'desc'    => __( 'Select how much columns should be on Portfolio Page.', 'sk8ter' ),
				'id'      => $prefix . 'portfolio_columns',
				'type'    => 'select',
				'options' => array(
					'2' 	=> __( '2', 'sk8ter' ),
					'3'   	=> __( '3', 'sk8ter' ),
					'4'     => __( '4', 'sk8ter' ),
				),
			),
			array(
				'name'    => __( 'Layout', 'sk8ter' ),
				'desc'    => __( 'In what Layout should posts be. Columns doesn\'t affect on Grid Layout.', 'sk8ter' ),
				'id'      => $prefix . 'portfolio_layout',
				'type'    => 'select',
				'options' => array(
					'normal' 				=> __( 'Normal', 'sk8ter' ),
					'grid'   				=> __( 'Grid', 'sk8ter' ),
				),
			),

			array(
				'name' => __( 'No Space Between Blocks', 'sk8er' ),
				'desc' => __( 'This also have no affect on Grid Layout.', 'sk8er' ),
				'id' => $prefix . 'portfolio_nospace',
				'type' => 'checkbox',
			),
			array(
				'name' => __( 'Show Sidebar', 'sk8er' ),
				'desc' => __( '', 'sk8er' ),
				'id' => $prefix . 'portfolio_sidebar',
				'type' => 'checkbox',
			),
		),
	);

	$meta_boxes['portfolio_messy_options'] = array(
		'id'         => 'portfolio_messy_options',
		'title'      => __( 'Messy Portfolio Options', 'sk8ter' ),
		'pages'      => array( 'page', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
			    'name' => 'Main Title',
			    'desc' => 'Wrap words in <code>< span > </code> tags if you want them little bigger and in italic.',
			    'id' => $prefix . 'portfolio_messy_title',
			    'type' => 'textarea'
			),

			array(
			    'name' => 'Subtitle',
			    'desc' => '',
			    'id' => $prefix . 'portfolio_messy_subtitle',
			    'type' => 'text_medium'
			),

			array(
			    'name' => 'Text Block 1: Titlte',
			    'desc' => '',
			    'id' => $prefix . 'portfolio_messy_text_1_title',
			    'type' => 'text_medium'
			),

			array(
			    'name' => 'Text Block 1: Text',
			    'desc' => '',
			    'id' => $prefix . 'portfolio_messy_text_1_text',
			    'type' => 'textarea'
			),

			array(
			    'name' => 'Text Block 2: Titlte',
			    'desc' => '',
			    'id' => $prefix . 'portfolio_messy_text_2_title',
			    'type' => 'text_medium'
			),

			array(
			    'name' => 'Text Block 2: Text',
			    'desc' => '',
			    'id' => $prefix . 'portfolio_messy_text_2_text',
			    'type' => 'textarea'
			),

			array(
			    'name' => 'Image 1',
			    'desc' => 'Upload an image or enter an URL.',
			    'id' => $prefix . 'portfolio_messy_image_1',
			    'type' => 'file',
			    'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),

			array(
			    'name' => 'Image 2',
			    'desc' => 'Upload an image or enter an URL.',
			    'id' => $prefix . 'portfolio_messy_image_2',
			    'type' => 'file',
			    'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),

			array(
			    'name' => 'Image 3',
			    'desc' => 'Upload an image or enter an URL.',
			    'id' => $prefix . 'portfolio_messy_image_3',
			    'type' => 'file',
			    'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),

			array(
			    'name' => 'Image 4',
			    'desc' => 'Upload an image or enter an URL.',
			    'id' => $prefix . 'portfolio_messy_image_4',
			    'type' => 'file',
			    'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),

			array(
			    'name' => 'Image 5',
			    'desc' => 'Upload an image or enter an URL.',
			    'id' => $prefix . 'portfolio_messy_image_5',
			    'type' => 'file',
			    'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),

			array(
			    'name' => 'Image 6',
			    'desc' => 'Upload an image or enter an URL.',
			    'id' => $prefix . 'portfolio_messy_image_6',
			    'type' => 'file',
			    'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),

			array(
			    'name' => 'Image 7',
			    'desc' => 'Upload an image or enter an URL.',
			    'id' => $prefix . 'portfolio_messy_image_7',
			    'type' => 'file',
			    'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),

			array(
			    'name' => 'Image 8',
			    'desc' => 'Upload an image or enter an URL.',
			    'id' => $prefix . 'portfolio_messy_image_8',
			    'type' => 'file',
			    'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),
			array(
			    'id'          => $prefix . 'portfolio_messy_social',
			    'type'        => 'group',
			    'description' => __( 'Social Network Links (If you add here new ones, then global social links will ', 'cmb2' ),
			    'options'     => array(
			        'group_title'   => __( 'Social Network {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
			        'add_button'    => __( 'Add Another', 'cmb2' ),
			        'remove_button' => __( 'Remove', 'cmb2' ),
			        'sortable'      => true, // beta
			    ),
			    // Fields array works the same, except id's only need to be unique for this group. Prefix is not needed.
			    'fields'      => array(
			        array(
        			    'name' => 'Social Network Name',
        			    'id' => 'name',
        			    'type' => 'text_medium'
        			),
        			array(
        			    'name' => 'URL',
        			    'id' => 'url',
        			    'type' => 'text_medium'
        			),
			    ),
			),
		),
	);

	$meta_boxes['post_standard_options'] = array(
		'id'         => 'post_standard_options',
		'title'      => __( 'Post options', 'sk8ter' ),
		'pages'      => array( 'post', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
			    'name' => 'Slider Images',
			    'desc' => 'If you add images here, post will have slider in it.',
			    'id' => $prefix . 'slider_images',
			    'type' => 'file_list',
			    'allow' => array( 'url', 'attachment' ),
			    'preview_size' => array( 100, 100 ),
			),
		),
	);

	$meta_boxes['post_video_options'] = array(
		'id'         => 'post_video_options',
		'title'      => __( 'Post options', 'sk8ter' ),
		'pages'      => array( 'post', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
			    'name' => 'Vimeo Video ID',
			    'desc' => 'Just paste ID of Video.',
			    'id' => $prefix . 'video_vimeo_id',
			    'type' => 'text_medium'
			),
			array(
			    'name' => 'Youtube Video ID',
			    'desc' => 'Just paste ID of Video.',
			    'id' => $prefix . 'video_youtube_id',
			    'type' => 'text_medium'
			),
			array(
			    'name' => 'Direct MP4 Link',
			    'desc' => 'Just paste direct .MP4 link.',
			    'id' => $prefix . 'video_mp4',
			    'type' => 'text_medium'
			),
			array(
			    'name' => 'Slider Images',
			    'desc' => 'Upload Video to your host.',
			    'id' => $prefix . 'video_hosted',
			    'type' => 'file',
			    'allow' => array( 'attachment' ),
			    'preview_size' => array( 100, 100 ),
			),
		),
	);

	$meta_boxes['single_portfolio_options'] = array(
		'id'         => 'single_portfolio_options',
		'title'      => __( 'Post options', 'sk8ter' ),
		'pages'      => array( 'portfolio', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
			    'name' => 'Images',
			    'desc' => 'Upload Images',
			    'id' => $prefix . 'portfolio_images',
			    'type' => 'file_list',
			    'allow' => array( 'attachment' ),
			    'preview_size' => array( 100, 100 ),
			),
			array(
				'name' => __( 'Is Slider?', 'sk8er' ),
				'desc' => __( '', 'sk8er' ),
				'id' => $prefix . 'portfolio_images_slider',
				'type' => 'checkbox',
			),
			array(
				'name'    => __( 'Images Layout', 'sk8ter' ),
				'desc'    => __( 'In what Layout should images be. If <b>is slider</b>, then this won\'t affect on layout.', 'sk8ter' ),
				'id'      => $prefix . 'portfolio_images_layout',
				'type'    => 'select',
				'options' => array(
					'normal' 				=> __( 'Normal (in content)', 'sk8ter' ),
					'grid'   				=> __( 'Grid (above content)', 'sk8ter' ),
					'grid2'   				=> __( 'Grid 2 (above content)', 'sk8ter' ),
					'fullwidth'   			=> __( 'Full Width (above content)', 'sk8ter' ),
				),
			),
			array(
			    'name' => 'Client Name',
			    'desc' => '',
			    'id' => $prefix . 'portfolio_client_name',
			    'type' => 'text_medium'
			),
			array(
			    'name' => 'Client Site URL',
			    'desc' => 'Include <b>http://</b> before everything.',
			    'id' => $prefix . 'portfolio_client_url',
			    'type' => 'text_medium'
			),
			array(
			    'name' => 'Task(s)',
			    'desc' => '',
			    'id' => $prefix . 'portfolio_tasks',
			    'type' => 'text_medium'
			),
			array(
			    'id'          => $prefix . 'portfolio_additional_info',
			    'type'        => 'group',
			    'description' => __( 'Additional Info Box (Optional)', 'cmb2' ),
			    'options'     => array(
			        'group_title'   => __( 'Additional Info {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
			        'add_button'    => __( 'Add Another Info', 'cmb2' ),
			        'remove_button' => __( 'Remove Info', 'cmb2' ),
			        'sortable'      => true, // beta
			    ),
			    // Fields array works the same, except id's only need to be unique for this group. Prefix is not needed.
			    'fields'      => array(
			        array(
			            'name' => 'Icon',
			            'desc' => 'Go <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a> and choose icon you want, then just paste name like this: <b>fa-clock-o</b>',
			            'id'   => 'icon',
			            'type' => 'text_medium',
			        ),
			        array(
        			    'name' => 'Title',
        			    'id' => 'title',
        			    'type' => 'text_medium'
        			),
        			array(
        			    'name' => 'Text',
        			    'id' => 'text',
        			    'type' => 'text_medium'
        			),
			    ),
			),
		),
	);

	$meta_boxes['single_member_options'] = array(
		'id'         => 'single_member_options',
		'title'      => __( 'Member Info', 'sk8ter' ),
		'pages'      => array( 'members', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
			    'name' => 'Member Position',
			    'desc' => '',
			    'id' => $prefix . 'member_position',
			    'type' => 'text_medium'
			),
			array(
			    'name' => 'Transparent Image',
			    'desc' => 'You should upload transparent image here if you want to use Member Layout 2. It looks so much better :)',
			    'id' => $prefix . 'member_transparent_image',
			    'type' => 'file',
			    'allow' => array( 'attachment' ),
			    'preview_size' => array( 100, 100 ),
			),
			array(
			    'name' => 'Background Color (only for Members Page template)',
			    'id'   => $prefix . 'member_background_color',
			    'type' => 'colorpicker',
			    'default'  => '#bc1953',
			),
			array(
			    'id'          => $prefix . 'member_social',
			    'type'        => 'group',
			    'description' => __( 'Social Networks', 'cmb2' ),
			    'options'     => array(
			        'group_title'   => __( 'Social Network {#}', 'cmb2' ), // since version 1.1.4, {#} gets replaced by row number
			        'add_button'    => __( 'Add Another Network', 'cmb2' ),
			        'remove_button' => __( 'Remove Network', 'cmb2' ),
			        'sortable'      => true, // beta
			    ),
			    // Fields array works the same, except id's only need to be unique for this group. Prefix is not needed.
			    'fields'      => array(
			        array(
			            'name' => 'Icon',
			            'desc' => 'Go <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a> and choose icon you want, then just paste name like this: <b>fa-facebook</b>',
			            'id'   => 'icon',
			            'type' => 'text_medium',
			        ),
			        array(
        			    'name' => 'Name',
        			    'id' => 'name',
        			    'type' => 'text_medium'
        			),
        			array(
        			    'name' => 'URL',
        			    'id' => 'url',
        			    'type' => 'text_medium'
        			),
			    ),
			),
		),
	);

	$meta_boxes['single_event_options'] = array(
		'id'         => 'single_event_options',
		'title'      => __( 'Event Info <small style="color: #888;display:block;"><i>Everything below is required in order for layout to show properly.</i></small>', 'sk8ter' ),
		'pages'      => array( 'events', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
			    'name' => '[Event Block Info] Event Date',
			    'desc' => '',
			    'id' => $prefix . 'event_date',
			    'type' => 'text_medium'
			),
			array(
			    'name' => '[Event Block Info] Event City',
			    'desc' => '',
			    'id' => $prefix . 'event_city',
			    'type' => 'text_medium'
			),
			array(
			    'name' => '[Event Block Info] Background Image',
			    'desc' => '',
			    'id' => $prefix . 'event_image',
			    'type' => 'file',
			    'allow' => array( 'attachment' ),
			    'preview_size' => array( 100, 100 ),
			),
			array(
			    'name' => '[Event Block Quote] Smaller text',
			    'desc' => '',
			    'id' => $prefix . 'event_quote_smaller',
			    'type' => 'text_medium'
			),
			array(
			    'name' => '[Event Block Quote] Bigger text',
			    'desc' => '',
			    'id' => $prefix . 'event_quote_bigger',
			    'type' => 'text_medium'
			),
			array(
			    'name' => '[Event Block] Single Image',
			    'desc' => '',
			    'id' => $prefix . 'event_single_image',
			    'type' => 'file',
			    'allow' => array( 'attachment' ),
			    'preview_size' => array( 100, 100 ),
			),
		),
	);

	$meta_boxes['tabs_section'] = array(
		'id'         => 'tabs_section',
		'title'      => __( 'Wine Tabs Section', 'sk8ter' ),
		'pages'      => array( 'page', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(

			array(
				'id'          => $prefix . 'tabs_section',
				'type'        => 'group',
				'description' => __( 'Here add Tabs you want to show in section', 'cmb' ),
				'options'     => array(
					'group_title'   => __( 'Tab {#}', 'cmb' ), // {#} gets replaced by row number
					'add_button'    => __( 'Add Another Tab', 'cmb' ),
					'remove_button' => __( 'Remove Tab', 'cmb' ),
					'sortable'      => true, // beta
				),
				// Fields array works the same, except id's only need to be unique for this group. Prefix is not needed.
				'fields'      => array(
					array(
						'name' => 'Tab Title',
						'id'   => 'title',
						'type' => 'text',
						// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
					),
					array(
						'name' => 'Tab Image',
						'id'   => 'image',
						'type' => 'file',
					),
					array(
						'name' => 'Year of Wine',
						'id'   => 'content_year',
						'type' => 'text',
						// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
					),
					array(
						'name' => 'Tab Content Text',
						'description' => 'Write a short description',
						'id'   => 'content_text',
						'type' => 'textarea_small',
					),
					array(
						'name' => 'Tab Content Image',
						'id'   => 'content_image',
						'type' => 'file',
					),
					array(
						'name' => 'Tab Content Background',
						'id'   => 'content_background_image',
						'type' => 'file',
						'default'	=> '',
					),
					array(
						'name' => __( 'Image on right?', 'cmb' ),
						'desc' => __( 'If\'s not checked, image will be on the left side.', 'cmb' ),
						'id'   => 'content_image_align',
						'type' => 'checkbox',
					),
				),
			),
		),
	);

	$meta_boxes['single_wine_options'] = array(
		'id'         => 'single_wine_options',
		'title'      => __( 'Wine Post Options', 'sk8ter' ),
		'pages'      => array( 'wines', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
			    'name' => 'Wine Year',
			    'desc' => '',
			    'id' => $prefix . 'wine_year',
			    'type' => 'text_medium'
			),
			array(
			    'name' => 'Thumb background Image (optional)',
			    'desc' => '',
			    'id' => $prefix . 'wine_thumb_bg',
			    'type' => 'file',
			    'allow' => array( 'attachment' ),
			    'preview_size' => array( 100, 100 ),
			),
		),
	);

	$meta_boxes['single_services_options'] = array(
		'id'         => 'single_services_options',
		'title'      => __( 'Services Post Options', 'sk8ter' ),
		'pages'      => array( 'services', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
			    'name' => 'Services Icon',
			    'desc' => 'Go <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a>, find icon you like, paste here name like this: <b>fa-university</b>',
			    'id' => $prefix . 'services_icon',
			    'type' => 'text_medium'
			),
		),
	);

	$meta_boxes['single_shop_news_options'] = array(
		'id'         => 'single_shop_news_options',
		'title'      => __( 'Shop News Post Options', 'sk8ter' ),
		'pages'      => array( 'shop_news', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
			    'name' => 'Title (smaller)',
			    'desc' => '',
			    'id' => $prefix . 'shop_news_title_smaller',
			    'type' => 'text_medium'
			),
			array(
			    'name' => 'Title (bigger)',
			    'desc' => '',
			    'id' => $prefix . 'shop_news_title_bigger',
			    'type' => 'text_medium'
			),
		),
	);

	$meta_boxes['post_link_options'] = array(
		'id'         => 'post_link_options',
		'title'      => __( 'Link Post Options', 'sk8ter' ),
		'pages'      => array( 'post', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
			    'name' => 'URL',
			    'desc' => 'Paste URL Here.',
			    'id' => $prefix . 'link_url',
			    'type' => 'text_medium'
			),
		),
	);

	$meta_boxes['post_audio_options'] = array(
		'id'         => 'post_audio_options',
		'title'      => __( 'Audio Post Options', 'sk8ter' ),
		'pages'      => array( 'post', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
			    'name' => 'ID',
			    'desc' => 'Paste SoundCloud Song ID Here',
			    'id' => $prefix . 'audio_id',
			    'type' => 'text_medium'
			),
		),
	);

	$meta_boxes['single_pricing_options'] = array(
		'id'         => 'single_pricing_options',
		'title'      => __( 'Post options', 'sk8ter' ),
		'pages'      => array( 'pricing_packages', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
			    'name' => 'Package Description',
			    'desc' => '',
			    'id' => $prefix . 'pricing_package_description',
			    'type' => 'text_medium'
			),

			array(
			    'name' => 'Price Currency',
			    'desc' => '',
			    'id' => $prefix . 'pricing_package_price_currency',
			    'type' => 'text_small'
			),
			array(
			    'name' => 'Price',
			    'desc' => '',
			    'id' => $prefix . 'pricing_package_price',
			    'type' => 'text_medium'
			),
			array(
				'name'    => __( 'Paying Period', 'sk8ter' ),
				'desc'    => __( '', 'sk8ter' ),
				'id'      => $prefix . 'pricing_package_paying_period',
				'type'    => 'select',
				'options' => array(
					'month' 		=> __( 'Month', 'sk8ter' ),
					'year'   		=> __( 'Year', 'sk8ter' ),
				),
			),
			array(
				'name' => __( 'Best Selling?', 'sk8er' ),
				'desc' => __( '', 'sk8er' ),
				'id' => $prefix . 'pricing_package_best',
				'type' => 'checkbox',
			),
		),
	);

	$meta_boxes['coming_soon_page'] = array(
		'id'         => 'coming_soon_page',
		'title'      => __( 'Post options', 'sk8ter' ),
		'pages'      => array( 'page', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
			    'name' => 'Page Title',
			    'desc' => '',
			    'id' => $prefix . 'coming_soon_title',
			    'type' => 'text_medium'
			),
			array(
			    'name' => 'Page Description',
			    'desc' => '',
			    'id' => $prefix . 'coming_soon_description',
			    'type' => 'textarea'
			),
			array(
			    'name' => 'Counter',
			    'desc' => '',
			    'id' => $prefix . 'coming_soon_counter',
			    'type' => 'text_date'
			),
			array(
			    'name' => 'Background Image',
			    'desc' => 'Upload an background image.',
			    'id' => $prefix . 'coming_soon_background',
			    'type' => 'file',
			    'allow' => array( 'url', 'attachment' ) // limit to just attachments with array( 'attachment' )
			),
		),
	);

	$meta_boxes['funfacts_options'] = array(
		'id'         => 'funfacts_options',
		'title'      => __( 'Fun Facts options', 'sk8ter' ),
		'pages'      => array( 'fun_facts', ), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		// 'cmb_styles' => true, // Enqueue the CMB stylesheet on the frontend
		'fields'     => array(
			array(
			    'name' => 'Fun Facts Number',
			    'desc' => '',
			    'id' => $prefix . 'funfacts_number',
			    'type' => 'text_medium'
			),
		),
	);


	// Add other metaboxes as needed
	return $meta_boxes;
}

add_action( 'init', 'cmb_initialize_cmb_meta_boxes', 9999 );
/**
 * Initialize the metabox class.
 */
function cmb_initialize_cmb_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once 'init.php';

}


function cmb_taxonomy_meta_initiate() {

    require_once('Taxonomy_MetaData_CMB.php' );

    /**
     * Semi-standard CMB metabox/fields array
     */
    $meta_box = array(
        'id'         => 'sk8er_cat_options',
        'show_on'    => array( 'key' => 'options-page', 'value' => array( 'unknown', ), ),
        'show_names' => true, // Show field names on the left
        'fields'     => array(
            array(
                'name' => __( 'Category Title Background', 'taxonomy-metadata' ),
                'desc' => __( '', 'taxonomy-metadata' ),
                'id'   => 'sk8er_category_image', // no prefix needed since the options are one option array.
                'type' => 'file',
            ),
        )
    );


    /**
     * Instantiate our taxonomy meta class
     */
    $cats = new Taxonomy_MetaData_CMB( 'category', $meta_box, __( 'Category Settings', 'taxonomy-metadata' ) );
}
cmb_taxonomy_meta_initiate();