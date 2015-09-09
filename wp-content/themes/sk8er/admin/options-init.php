<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux_Framework_sample_config' ) ) {

        class Redux_Framework_sample_config {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                    $this->initSettings();
                } else {
                    add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
                }

            }

            public function initSettings() {

                // Just for demo purposes. Not needed per say.
                $this->theme = wp_get_theme();

                // Set the default arguments
                $this->setArguments();

                // Set a few help tabs so you can see how it's done
                $this->setHelpTabs();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                // If Redux is running as a plugin, this will remove the demo notice and links
                //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

                // Function to test the compiler hook and demo CSS output.
                // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
                //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);

                // Change the arguments after they've been declared, but before the panel is created
                //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );

                // Change the default value of a field after it's been set, but before it's been useds
                //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );

                // Dynamically add a section. Can be also used to modify sections/fields
                //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            /**
             * This is a test function that will let you see when the compiler hook occurs.
             * It only runs if a field    set with compiler=>true is changed.
             * */
            function compiler_action( $options, $css, $changed_values ) {
                echo '<h1>The compiler hook has run!</h1>';
                echo "<pre>";
                print_r( $changed_values ); // Values that have changed since the last save
                echo "</pre>";
                //print_r($options); //Option values
                //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

                /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
            }

            /**
             * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
             * Simply include this function in the child themes functions.php file.
             * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
             * so you must use get_template_directory_uri() if you want to use any of the built in icons
             * */
            function dynamic_section( $sections ) {
                //$sections = array();
                $sections[] = array(
                    'title'  => __( 'Section via hook', 'sk8er' ),
                    'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'sk8er' ),
                    'icon'   => 'el-icon-paper-clip',
                    // Leave this as a blank section, no options just some intro text set above.
                    'fields' => array()
                );

                return $sections;
            }

            /**
             * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
             * */
            function change_arguments( $args ) {
                //$args['dev_mode'] = true;

                return $args;
            }

            /**
             * Filter hook for filtering the default value of any given field. Very useful in development mode.
             * */
            function change_defaults( $defaults ) {
                $defaults['str_replace'] = 'Testing filter hook!';

                return $defaults;
            }

            // Remove the demo link and the notice of integrated demo from the redux-framework plugin
            function remove_demo() {

                // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    remove_filter( 'plugin_row_meta', array(
                        ReduxFrameworkPlugin::instance(),
                        'plugin_metalinks'
                    ), null, 2 );

                    // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                    remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
                }
            }

            public function setSections() {

                /**
                 * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
                 * */
                // Background Patterns Reader
                $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
                $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
                $sample_patterns      = array();

                if ( is_dir( $sample_patterns_path ) ) :

                    if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
                        $sample_patterns = array();

                        while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                            if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                                $name              = explode( '.', $sample_patterns_file );
                                $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                                $sample_patterns[] = array(
                                    'alt' => $name,
                                    'img' => $sample_patterns_url . $sample_patterns_file
                                );
                            }
                        }
                    endif;
                endif;

                ob_start();

                $ct          = wp_get_theme();
                $this->theme = $ct;
                $item_name   = $this->theme->get( 'Name' );
                $tags        = $this->theme->Tags;
                $screenshot  = $this->theme->get_screenshot();
                $class       = $screenshot ? 'has-screenshot' : '';

                $customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'sk8er' ), $this->theme->display( 'Name' ) );

                ?>
                <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
                    <?php if ( $screenshot ) : ?>
                        <?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                            <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize"
                               title="<?php echo esc_attr( $customize_title ); ?>">
                                <img src="<?php echo esc_url( $screenshot ); ?>"
                                     alt="<?php esc_attr_e( 'Current theme preview', 'sk8er' ); ?>"/>
                            </a>
                        <?php endif; ?>
                        <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>"
                             alt="<?php esc_attr_e( 'Current theme preview', 'sk8er' ); ?>"/>
                    <?php endif; ?>

                    <h4><?php echo $this->theme->display( 'Name' ); ?></h4>

                    <div>
                        <ul class="theme-info">
                            <li><?php printf( __( 'By %s', 'sk8er' ), $this->theme->display( 'Author' ) ); ?></li>
                            <li><?php printf( __( 'Version %s', 'sk8er' ), $this->theme->display( 'Version' ) ); ?></li>
                            <li><?php echo '<strong>' . __( 'Tags', 'sk8er' ) . ':</strong> '; ?><?php printf( $this->theme->display( 'Tags' ) ); ?></li>
                        </ul>
                        <p class="theme-description"><?php echo $this->theme->display( 'Description' ); ?></p>
                        <?php
                            if ( $this->theme->parent() ) {
                                printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'sk8er' ) . '</p>', __( 'http://codex.wordpress.org/Child_Themes', 'sk8er' ), $this->theme->parent()->display( 'Name' ) );
                            }
                        ?>

                    </div>
                </div>

                <?php
                $item_info = ob_get_contents();

                ob_end_clean();

                $sampleHTML = '';
                if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
                    Redux_Functions::initWpFilesystem();

                    global $wp_filesystem;

                    $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
                }

                $this->sections[] = array(
                    'title'  => __( 'Theme Customization', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-cogs',
                    'fields' => array(
                        array(
                            'id'       => 'sk8er_custom_css',
                            'type'     => 'ace_editor',
                            'title'    => __( 'CSS Code', 'sk8er' ),
                            'subtitle' => __( 'Paste your CSS code here.', 'sk8er' ),
                            'mode'     => 'css',
                            'theme'    => 'monokai',
                            'desc'     => '',
                            'default'  => "#selector{\nmargin: 0 auto;\n}"
                        ),
                        array(
                            'id'       => 'sk8er_main_color',
                            'type'     => 'color',
                            'output'   => array( '' ),
                            'title'    => __( 'Main Theme Color', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'default'  => '#ec2c55',
                            'validate' => 'color',
                        ),
                        array(
                            'id'       => 'sk8er_hover_color',
                            'type'     => 'color_rgba',
                            'title'    => __( 'Color on hover on some elements.', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'default'  => array(
                                'color' => '#ec2c55',
                                'alpha' => '.75'
                            ),
                            'output'   => array( '' ),
                            'mode'     => 'background',
                            'validation'=>'color_rgba'
                        ),

                        array(
                            'id'       => 'sk8er_widget_sidebar_bg',
                            'type'     => 'color',
                            'output'   => array( '' ),
                            'title'    => __( 'Widget Sidebar Background', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'default'  => '#ec2c55',
                            'validate' => 'color',
                        ),
                    ),
                );

                $this->sections[] = array(
                    'type' => 'divide',
                );

                // ACTUAL DECLARATION OF SECTIONS
                $this->sections[] = array(
                    'title'  => __( 'General Settings', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-cogs',
                    'fields' => array(
                        array(
                            'id'       => 'sk8er_logo',
                            'type'     => 'media',
                            'title'    => __( 'Main Logo Image', 'sk8er' ),
                            'compiler' => 'true',
                            'mode'     => false,
                        ),
                        array(
                            'id'       => 'sk8er_favicon',
                            'type'     => 'media',
                            'title'    => __( 'Favicon (16x16px)', 'sk8er' ),
                            'compiler' => 'true',
                            'mode'     => false,
                        ),
                         array(
                            'id' => 'sk8er_header_submenu_theme',
                            'type' => 'select',
                            'title' => __( 'Header Submenu Theme', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'options' => array( 'theme_light' => 'theme_light', 'theme_dark' => 'theme_dark' ),
                            'default' => 'theme_dark',
                        ),
                          array(
                             'id' => 'header_over_next',
                             'type' => 'switch',
                             'title' => __( 'Floating Over next Section', 'sk8er' ),
                             'subtitle' => __( 'Some Headers will may not be affected by this option and some Headers work with this enabled/disabled. This work best with Revolution Slider enabled on Pages.', 'sk8er' ),
                         ),
                         array(
                            'id' => 'sk8er_header',
                            'type' => 'image_select',
                            'presets' => true,
                            'title' => __( 'Header Style', 'sk8er' ),
                            'subtitle' => __( 'Choose Header Style', 'sk8er' ),
                            'default' => 1,
                            'desc' => __( '', 'sk8er' ),

                        'options' => array(
                            '1' => array(
                                'alt' => 'Style 1',
                                'img' => get_template_directory_uri() .'/img/redux/header-style-1.png',
                            ),
                            '2' => array(
                                'alt' => 'Style 2',
                                'img' => get_template_directory_uri() .'/img/redux/header-style-2.png',
                            ),
                            '3' => array(
                                'alt' => 'Style 3',
                                'img' => get_template_directory_uri() .'/img/redux/header-style-3.png',
                            ),
                            '4' => array(
                                'alt' => 'Style 4',
                                'img' => get_template_directory_uri() .'/img/redux/header-style-4.png',
                            ),
                            '5' => array(
                                'alt' => 'Style 5',
                                'img' => get_template_directory_uri() .'/img/redux/header-style-5.png',
                            ),
                            '6' => array(
                                'alt' => 'Style 6',
                                'img' => get_template_directory_uri() .'/img/redux/header-style-6.png',
                            ),
                            '7' => array(
                                'alt' => 'Style 7',
                                'img' => get_template_directory_uri() .'/img/redux/header-style-7.png',
                            ),
                            '8' => array(
                                'alt' => 'Style 8',
                                'img' => get_template_directory_uri() .'/img/redux/header-style-8.png',
                            ),
                            '9' => array(
                                'alt' => 'Style 9',
                                'img' => get_template_directory_uri() .'/img/redux/header-style-9.png',
                            ),
                            '10' => array(
                                'alt' => 'Style 10',
                                'img' => get_template_directory_uri() .'/img/redux/header-style-10.png',
                            ),
                            '11' => array(
                                'alt' => 'Style 11',
                                'img' => get_template_directory_uri() .'/img/redux/header-style-11.png',
                            ),
                            '12' => array(
                                'alt' => 'Style 12',
                                'img' => get_template_directory_uri() .'/img/redux/header-style-12.png',
                            ),
                        ),
                        ),

                        array(
                            'id'       => 'sk8er_header_info',
                            'type'     => 'text',
                            'title'    => __( 'Header info for 7th Header Style.', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),

                         array(
                            'id' => 'sk8er_footer',
                            'type' => 'image_select',
                            'presets' => true,
                            'title' => __( 'Footer Style', 'sk8er' ),
                            'subtitle' => __( 'Choose Footer Style', 'sk8er' ),
                            'default' => 1,
                            'desc' => __( '', 'sk8er' ),

                        'options' => array(
                            '1' => array(
                                'alt' => 'Style 1',
                                'img' => get_template_directory_uri() .'/img/redux/footer-style-1.png',
                            ),
                            '2' => array(
                                'alt' => 'Style 2',
                                'img' => get_template_directory_uri() .'/img/redux/footer-style-2.png',
                            ),
                            '3' => array(
                                'alt' => 'Style 3',
                                'img' => get_template_directory_uri() .'/img/redux/footer-style-3.png',
                            ),
                        ),
                        ),

                         array(
                            'id' => 'sk8er_footer_widget',
                            'type' => 'switch',
                            'title' => __( 'Widget Footer', 'sk8er' ),
                            'subtitle' => __( 'On some pages this will maybe be hidden.', 'sk8er' ),
                        ),

                         array(
                             'id'          => 'sk8er_footer_info',
                             'type'        => 'slides',
                             'title'       => __( 'Footer Info (style 3)', 'sk8er' ),
                             'subtitle'    => __( 'Go <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a> and choose icon then just paste name here like <b>fa-facebook</b>.', 'sk8er' ),
                             'placeholder' => array(
                                 'title'       => __( 'Title', 'sk8er' ),
                                 'description' => __( 'Text', 'sk8er' ),
                                 'url'         => __( 'Class name.', 'sk8er' ),
                             ),
                         ),

                         array(
                             'id'       => 'sk8er_footer_subscribe',
                             'type'     => 'text',
                             'title'    => __( 'Footer Subscribe Form Shortcode', 'sk8er' ),
                             'subtitle' => __( '', 'sk8er' ),
                             'desc'     => __( '', 'sk8er' ),
                         ),

                        array(
                            'id'       => 'sk8er_footer_copyright',
                            'type'     => 'text',
                            'title'    => __( 'Footer Copyright Text', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),

                        array(
                            'id'       => 'sk8er_footer_copyright_link',
                            'type'     => 'text',
                            'title'    => __( 'Footer Copyright Link', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),

                        array(
                            'id'       => 'sk8er_header_weather_bg',
                            'type'     => 'media',
                            'title'    => __( 'Weather Background Image (Fallback for Post Thumbnail, optional)', 'sk8er' ),
                            'compiler' => 'true',
                            'mode'     => false,
                        ),

                        array(
                            'id'       => 'sk8er_bigpagetitle_background',
                            'type'     => 'media',
                            'title'    => __( 'Default Big Page Title Background', 'sk8er' ),
                            'compiler' => 'true',
                            'mode'     => false,
                        ),
                        array(
                            'id'       => 'sk8er_404_bg',
                            'type'     => 'media',
                            'title'    => __( '404 Background Image', 'sk8er' ),
                            'compiler' => 'true',
                            'mode'     => false,
                        ),
                        array(
                            'id'          => 'sk8er_social',
                            'type'        => 'slides',
                            'title'       => __( 'Social Network Links', 'sk8er' ),
                            'subtitle'    => __( 'Go <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a> and choose icon then just paste name here like <b>fa-facebook</b>.', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Social Network', 'sk8er' ),
                                'description' => __( 'Icon Name', 'sk8er' ),
                                'url'         => __( 'Link (Include http:// before)', 'sk8er' ),
                            ),
                        ),
                        array(
                            'id'       => 'sk8er_post_likes',
                            'type'     => 'switch',
                            'title'    => __( 'Blog Post Likes', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'default'  => 1,
                            'on'       => 'Enabled',
                            'off'      => 'Disabled',
                        ),

                        array(
                            'id'       => 'sk8er_footer_instagram_feed',
                            'type'     => 'text',
                            'title'    => __( 'Footer Widget Instagram, UserID', 'sk8er' ),
                            'subtitle' => __( 'Leave Empty if you don\'t want this widget.', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_footer_shortcode_feed',
                            'type'     => 'text',
                            'title'    => __( 'Footer Custom Shortcode', 'sk8er' ),
                            'subtitle' => __( 'This is only active if Instagram Feed isn\'t. You can add facebook feed easly by installing <b>Custom Facebook Feed</b> and pasting here shortcode from plugin like this: <i>[custom-facebook-feed]</i>', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),

                        array(
                            'id'       => 'sk8er_footer_about_text',
                            'type'     => 'text',
                            'title'    => __( 'Footer About Text', 'sk8er' ),
                            'subtitle' => __( 'Leave Empty if you don\'t want this widget.', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),

                        array(
                            'id'       => 'sk8er_footer_about_link',
                            'type'     => 'text',
                            'title'    => __( 'Footer About Link', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),

                        array(
                            'id'       => 'sk8er_footer_about_link_text',
                            'type'     => 'text',
                            'title'    => __( 'Footer About Link Text', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),

                        array(
                            'id'       => 'sk8er_google_analytics',
                            'type'     => 'text',
                            'title'    => __( 'Google Analytics Tracking ID', 'sk8er' ),
                            'subtitle' => __( 'Enter here only tracking id like this: <b>UA-60210660-1</b>', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'type' => 'divide',
                );

                $this->sections[] = array(
                    'title'  => __( 'Services', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-certificate',
                    'fields' => array(
                        array(
                            'id'          => 'sk8er_services',
                            'type'        => 'slides',
                            'title'       => __( 'Our Services', 'sk8er' ),
                            'description' => __( 'For best look, min. 3 services would be best choice :)', 'sk8er'),
                            'subtitle'    => __( 'Go <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a> and choose icon then just paste name here like <b>fa-facebook</b>.', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Title', 'sk8er' ),
                                'description' => __( 'Description', 'sk8er' ),
                                'url'         => __( 'Icon', 'sk8er' ),
                            ),
                        ),
                    ),
                );
                $this->sections[] = array(
                    'title'  => __( 'Testimonials', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-group',
                    'fields' => array(
                        array(
                            'id'          => 'sk8er_testimonials',
                            'type'        => 'slides',
                            'title'       => __( 'Testimonials', 'sk8er' ),
                            'description' => __( '', 'sk8er'),
                            'subtitle'    => __( 'Upload Image and fill rest of the fields.', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Name', 'sk8er' ),
                                'description' => __( 'Testimonial', 'sk8er' ),
                                'url'         => __( 'One-word impression.', 'sk8er' ),
                            ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Benefits Section', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-link',
                    'fields' => array(
                        array(
                            'id'          => 'sk8er_benefits_section',
                            'type'        => 'slides',
                            'title'       => __( 'Benefits', 'sk8er' ),
                            'description' => __( '', 'sk8er'),
                            'subtitle'    => __( 'Go <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a>, choose icon and then paste name here like this: <b>fa-clock-o</b>', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Main Title', 'sk8er' ),
                                'description' => __( 'Subtitle', 'sk8er' ),
                                'url'         => __( 'Icon Class', 'sk8er' ),
                            ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Image with details', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-picture',
                    'fields' => array(
                        array(
                            'id'       => 'sk8er_iwd_image',
                            'type'     => 'media',
                            'title'    => __( 'Image', 'sk8er' ),
                            'compiler' => 'true',
                            'mode'     => false,
                        ),
                        array(
                            'id'          => 'sk8er_iwd_details',
                            'type'        => 'slides',
                            'title'       => __( 'Details', 'sk8er' ),
                            'description' => __( 'Example for Position: <b>top: 35%; left: 73%;</b>', 'sk8er'),
                            'subtitle'    => __( 'Upload Image, add Title, Price/description (no more than 35 characters), type position of detail marker.', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Title', 'sk8er' ),
                                'description' => __( 'Description/price', 'sk8er' ),
                                'url'         => __( 'top: 35%;left:73%;', 'sk8er' ),
                            ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Products (Table)', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-briefcase',
                    'fields' => array(
                        array(
                            'id'          => 'sk8er_products_table',
                            'type'        => 'slides',
                            'title'       => __( 'Products', 'sk8er' ),
                            'description' => __( '', 'sk8er'),
                            'subtitle'    => __( 'Upload Image (transparent works best and it\'s recommended) and fill the rest fields.', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Title', 'sk8er' ),
                                'description' => __( 'Description', 'sk8er' ),
                                'url'         => __( 'Leave empty.', 'sk8er' ),
                            ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Star Features', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-star',
                    'fields' => array(
                        array(
                            'id'          => 'sk8er_star_features',
                            'type'        => 'slides',
                            'title'       => __( 'Features', 'sk8er' ),
                            'description' => __( '', 'sk8er'),
                            'subtitle'    => __( 'Upload Image (transparent works best and it\'s recommended) and fill the rest fields.', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Title', 'sk8er' ),
                                'description' => __( 'Description (write in <p>...</p> if you want to seperate text).', 'sk8er' ),
                                'url'         => __( 'Subtitle', 'sk8er' ),
                            ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'About Me', 'sk8er' ),
                    'desc'   => __( 'You should fill everything and upload all images for layout to be how\'s supposed to be :)' ),
                    'icon'   => 'el-icon-user',
                    'fields' => array(
                        array(
                            'id'       => 'sk8er_about_title',
                            'type'     => 'text',
                            'title'    => __( 'Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_about_subtitle',
                            'type'     => 'text',
                            'title'    => __( 'Subtitle', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_about_text',
                            'type'     => 'textarea',
                            'title'    => __( 'Text', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_about_bg_image',
                            'type'     => 'media',
                            'title'    => __( 'Background Image (optional)', 'sk8er' ),
                            'compiler' => 'true',
                            'mode'     => false,
                            'desc'     => __( 'Should be transparent and should be character', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_about_image_1',
                            'type'     => 'media',
                            'title'    => __( 'Image 1 (on side)', 'sk8er' ),
                            'compiler' => 'true',
                            'mode'     => false,
                            'desc'     => __( '', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_about_image_2',
                            'type'     => 'media',
                            'title'    => __( 'Image 2', 'sk8er' ),
                            'compiler' => 'true',
                            'mode'     => false,
                            'desc'     => __( '', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_about_image_3',
                            'type'     => 'media',
                            'title'    => __( 'Image 3', 'sk8er' ),
                            'compiler' => 'true',
                            'mode'     => false,
                            'desc'     => __( '', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_about_image_4',
                            'type'     => 'media',
                            'title'    => __( 'Image 4', 'sk8er' ),
                            'compiler' => 'true',
                            'mode'     => false,
                            'desc'     => __( '', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Soundcloud Section', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-soundcloud',
                    'fields' => array(
                        array(
                            'id'          => 'sk8er_soundcloud',
                            'type'        => 'slides',
                            'title'       => __( 'Tracks', 'sk8er' ),
                            'description' => __( '', 'sk8er'),
                            'subtitle'    => __( '', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Title', 'sk8er' ),
                                'description' => __( 'Track ID (only ID like: 34019569)', 'sk8er' ),
                                'url'         => __( 'Elements color (optional) (type HEX like: ffdb00)', 'sk8er' ),
                            ),
                        ),
                        array(
                            'id'       => 'sk8er_soundcloud_url',
                            'type'     => 'text',
                            'title'    => __( 'Soundcloud Profile URL', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_soundcloud_button',
                            'type'     => 'text',
                            'title'    => __( 'Button Text', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                            'default'  => __( 'Visit my Soundcloud Channel', 'sk8er' ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Contact Form', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-envelope',
                    'fields' => array(
                        array(
                            'id'       => 'sk8er_contact_shortcode',
                            'type'     => 'text',
                            'title'    => __( 'Shortcode from Contact Form 7', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_contact_info_1_title',
                            'type'     => 'text',
                            'title'    => __( 'Title for [1] Contact Form (optional)', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                         array(
                            'id' => 'sk8er_contact_info_1',
                            'type' => 'multi_text',
                            'title' => __( '[1] Contact Info', 'sk8er' ),
                            'subtitle' => __( 'Click <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a>, choose icon then paste name in Icon field like this: <b>fa-envelope</b>.' ),
                            'desc' => __( 'Write like this: <b>fa-envelope|Info Text</b>', 'sk8er' )
                        ),
                        array(
                            'id'       => 'sk8er_contact_info_2_title',
                            'type'     => 'text',
                            'title'    => __( 'Title for [2] Contact Form (optional)', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id' => 'sk8er_contact_info_2',
                            'type' => 'multi_text',
                            'title' => __( '[2] Contact Info', 'sk8er' ),
                            'subtitle' => __( 'Click <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a>, choose icon then paste name in Icon field like this: <b>fa-envelope</b>.' ),
                            'desc' => __( 'Write like this: <b>fa-envelope|Info Text</b>', 'sk8er' )
                        ),
                        array(
                            'id'       => 'sk8er_contact_info_3_title',
                            'type'     => 'text',
                            'title'    => __( 'Title for [3] Contact Form (optional)', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id' => 'sk8er_contact_info_3',
                            'type' => 'multi_text',
                            'title' => __( '[3] Contact Info', 'sk8er' ),
                            'subtitle' => __( 'Click <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a>, choose icon then paste name in Icon field like this: <b>fa-envelope</b>.' ),
                            'desc' => __( 'Write like this: <b>fa-envelope|Info Text</b>', 'sk8er' )
                        ),
                        array(
                            'id'       => 'sk8er_contact_info_4_title',
                            'type'     => 'text',
                            'title'    => __( 'Title for [4] Contact Form (optional)', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id' => 'sk8er_contact_info_4',
                            'type' => 'multi_text',
                            'title' => __( '[4] Contact Info', 'sk8er' ),
                            'subtitle' => __( 'Click <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a>, choose icon then paste name in Icon field like this: <b>fa-envelope</b>.' ),
                            'desc' => __( 'Write like this: <b>fa-envelope|Info Text</b>', 'sk8er' )
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Steps Section', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-tasks',
                    'fields' => array(
                        array(
                            'id'          => 'sk8er_steps',
                            'type'        => 'slides',
                            'title'       => __( 'Steps', 'sk8er' ),
                            'description' => __( '', 'sk8er'),
                            'subtitle'    => __( 'Upload Image or add icon, fill name field and you\'re done. For icon you can go to <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a>, find icon you like, paste name here like this: <i>fa-clock-o</i>', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Name', 'sk8er' ),
                                'description' => __( 'Icon Name', 'sk8er' ),
                                'url'         => __( 'Leave empty.', 'sk8er' ),
                            ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Steps (v2) Section', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-tasks',
                    'fields' => array(
                        array(
                            'id' => 'sk8er_stepsv2',
                            'type' => 'multi_text',
                            'title' => __( 'Just write step title.', 'sk8er' ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Steps (v3) Section', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-tasks',
                    'fields' => array(
                        array(
                            'id' => 'sk8er_stepsv3',
                            'type' => 'multi_text',
                            'title' => __( 'Just write step Description.', 'sk8er' ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Mockup Slider', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-graph',
                    'fields' => array(
                        array(
                            'id'          => 'sk8er_mockup_stats',
                            'type'        => 'slides',
                            'title'       => __( 'Stats', 'sk8er' ),
                            'description' => __( '', 'sk8er'),
                            'subtitle'    => __( '', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Title', 'sk8er' ),
                                'description' => __( 'Number', 'sk8er' ),
                                'url'         => __( 'Link (optional)', 'sk8er' ),
                            ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Products with Testimonials', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-website',
                    'fields' => array(
                        array(
                            'id'       => 'sk8er_pwt_background',
                            'type'     => 'media',
                            'title'    => __( 'Background Image', 'sk8er' ),
                            'compiler' => 'true',
                            'mode'     => false,
                        ),

                        array(
                            'id'       => 'sk8er_pwt_products_title',
                            'type'     => 'text',
                            'title'    => __( 'Products List Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_pwt_products_subtitle',
                            'type'     => 'text',
                            'title'    => __( 'Products List Subtitle', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                        ),
                        array(
                            'id' => 'sk8er_pwt_products',
                            'type' => 'multi_text',
                            'title' => __( 'Product List', 'sk8er' ),
                        ),
                        array(
                            'id'          => 'sk8er_pwt_testimonials',
                            'type'        => 'slides',
                            'title'       => __( 'Product Testimonials', 'sk8er' ),
                            'description' => __( 'Upload (transparent) Image and fill rest of the fields.', 'sk8er'),
                            'subtitle'    => __( '', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Name', 'sk8er' ),
                                'description' => __( 'Testimonial', 'sk8er' ),
                                'url'         => __( 'Position', 'sk8er' ),
                            ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Process and Tabs Section', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-credit-card',
                    'fields' => array(
                        array(
                            'id'          => 'sk8er_process_tabs',
                            'type'        => 'slides',
                            'title'       => __( 'Tabs', 'sk8er' ),
                            'description' => __( 'Upload image and fill rest of the fields.', 'sk8er'),
                            'subtitle'    => __( '', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Title', 'sk8er' ),
                                'description' => __( 'Text', 'sk8er' ),
                                'url'         => __( 'Subtitle', 'sk8er' ),
                            ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Info and Location Section', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-map-marker',
                    'fields' => array(
                        array(
                            'id'          => 'sk8er_ial_info',
                            'type'        => 'slides',
                            'title'       => __( 'Info', 'sk8er' ),
                            'description' => __( 'Upload image and fill rest of the fields.', 'sk8er'),
                            'subtitle'    => __( '', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Author', 'sk8er' ),
                                'description' => __( 'Quote/text', 'sk8er' ),
                                'url'         => __( 'Leave empty.', 'sk8er' ),
                            ),
                        ),
                        array(
                            'id'       => 'sk8er_ial_location',
                            'type'     => 'textarea',
                            'title'    => __( 'Google Maps', 'sk8er' ),
                            'subtitle' => __( 'Paste here <b>Longitude and Latitude</b> like this: <i>-37.866963,144.980615</i>', 'sk8er' ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'About with Slider Section', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-info-sign',
                    'fields' => array(
                        array(
                            'id'       => 'sk8er_aws_main_title',
                            'type'     => 'text',
                            'title'    => __( 'Main (Section) Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_aws_about_title',
                            'type'     => 'text',
                            'title'    => __( 'About Block Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id' => 'sk8er_aws_about_text',
                            'type' => 'multi_text',
                            'title' => __( 'Multi Text', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_aws_about_link',
                            'type'     => 'text',
                            'title'    => __( 'Link to About Page (optional)', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'          => 'sk8er_aws_slider',
                            'type'        => 'slides',
                            'title'       => __( 'Slider', 'sk8er' ),
                            'description' => __( '', 'sk8er'),
                            'subtitle'    => __( 'Upload Image and fill rest of the fields. For icon, go <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a>, find icon you like, paste name here like this: <b>fa-university</b>', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Title', 'sk8er' ),
                                'description' => __( 'Text', 'sk8er' ),
                                'url'         => __( 'Icon', 'sk8er' ),
                            ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'List and FAQ Section', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-question-sign',
                    'fields' => array(
                        array(
                            'id'       => 'sk8er_laf_list_image',
                            'type'     => 'media',
                            'title'    => __( 'List Background Image', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_laf_list_title',
                            'type'     => 'text',
                            'title'    => __( 'List Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                         array(
                            'id' => 'sk8er_laf_list_items',
                            'type' => 'multi_text',
                            'title' => __( 'List Items', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_laf_faq_title',
                            'type'     => 'text',
                            'title'    => __( 'FAQ Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                         array(
                            'id' => 'sk8er_laf_faq_items_text',
                            'type' => 'multi_text',
                            'title' => __( 'FAQ List', 'sk8er' ),
                            'subtitle' => __( 'Write like this: <b>Question|Answer</b>. (You must include vertical line between question and answer)', 'sk8er' )
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Minimal Info Section', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-info-sign',
                    'fields' => array(
                        array(
                            'id'       => 'sk8er_minimalinfo_title',
                            'type'     => 'text',
                            'title'    => __( 'Main Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                         array(
                            'id' => 'sk8er_minimalinfo_info_re',
                            'type' => 'multi_text',
                            'title' => __( 'Info', 'sk8er' ),
                            'subtitle' => __( 'For icon, go <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a>, find icon you like and then paste here name like this: <b>fa-facebook</b>', 'sk8er' ),
                            'desc' => __( 'Write like this: <b>fa-icon-name|Info Text</b>', 'sk8er' )
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Info Block', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-info-sign',
                    'fields' => array(
                        array(
                            'id'       => 'sk8er_ib_background',
                            'type'     => 'media',
                            'title'    => __( 'Background Image', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_ib_first_title',
                            'type'     => 'text',
                            'title'    => __( '[1] Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_ib_first_info',
                            'type'     => 'text',
                            'title'    => __( '[1] Number', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_ib_second_title',
                            'type'     => 'text',
                            'title'    => __( '[2] Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_ib_second_info',
                            'type'     => 'text',
                            'title'    => __( '[2] Number', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_ib_third_title',
                            'type'     => 'text',
                            'title'    => __( '[3] Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_ib_third_info',
                            'type'     => 'text',
                            'title'    => __( '[3] Number', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_ib_fourth_title',
                            'type'     => 'text',
                            'title'    => __( '[4] Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_ib_fourth_info',
                            'type'     => 'text',
                            'title'    => __( '[4] Text', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_ib_fifth_title',
                            'type'     => 'text',
                            'title'    => __( '[5] Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_ib_fifth_info',
                            'type'     => 'text',
                            'title'    => __( '[5] Text', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_ib_contact_link',
                            'type'     => 'text',
                            'title'    => __( 'Contact Link', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Google Map Section', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-map-marker',
                    'fields' => array(
                        array(
                            'id'       => 'sk8er_google_map_location',
                            'type'     => 'text',
                            'title'    => __( 'Map Position', 'sk8er' ),
                            'subtitle' => __( 'Write like this: <b><i>Latitude, Longitude</i></b>', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'          => 'sk8er_google_map_markers',
                            'type'        => 'slides',
                            'title'       => __( 'Markers', 'sk8er' ),
                            'description' => __( '', 'sk8er'),
                            'subtitle'    => __( 'Upload Marker Image or insert link for marker image.', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Marker Title', 'sk8er' ),
                                'description' => __( 'Latitude, Longitude', 'sk8er' ),
                                'url'         => __( 'URL to Marker Image.', 'sk8er' ),
                            ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Detailed Info Block', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-info-sign',
                    'fields' => array(
                        array(
                            'id'       => 'sk8er_detailed_first_icon_image',
                            'type'     => 'media',
                            'title'    => __( '[1] Icon Image', 'sk8er' ),
                            'compiler' => 'true',
                            'mode'     => false,
                        ),
                        array(
                            'id'       => 'sk8er_detailed_first_icon_fa',
                            'type'     => 'text',
                            'title'    => __( '[1] OR Icon Class', 'sk8er' ),
                            'subtitle' => __( 'Go <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a>, choose icon you like, paste name here like this: <b>fa-university</b>', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_detailed_first_main_title',
                            'type'     => 'text',
                            'title'    => __( '[1] Main Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_detailed_first_sub_title',
                            'type'     => 'text',
                            'title'    => __( '[1] Sub Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_detailed_first_text',
                            'type'     => 'textarea',
                            'title'    => __( '[1] Text', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_detailed_first_info_title',
                            'type'     => 'text',
                            'title'    => __( '[1] Detailed Info Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'          => 'sk8er_detailed_first_info',
                            'type'        => 'slides',
                            'title'       => __( '[1] Detailed Info', 'sk8er' ),
                            'description' => __( '', 'sk8er'),
                            'subtitle'    => __( 'Go <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a>, choose icon you like, paste name here like this: <b>fa-university</b>', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Info Text', 'sk8er' ),
                                'description' => __( 'Icon Class', 'sk8er' ),
                                'url'         => __( 'Leave Empty.', 'sk8er' ),
                            ),
                        ),

                        array(
                            'id'       => 'sk8er_detailed_second_icon_image',
                            'type'     => 'media',
                            'title'    => __( '[2] Icon Image', 'sk8er' ),
                            'compiler' => 'true',
                            'mode'     => false,
                        ),
                        array(
                            'id'       => 'sk8er_detailed_second_icon_fa',
                            'type'     => 'text',
                            'title'    => __( '[2] OR Icon Class', 'sk8er' ),
                            'subtitle' => __( 'Go <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a>, choose icon you like, paste name here like this: <b>fa-university</b>', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_detailed_second_main_title',
                            'type'     => 'text',
                            'title'    => __( '[2] Main Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_detailed_second_sub_title',
                            'type'     => 'text',
                            'title'    => __( '[2] Sub Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_detailed_second_text',
                            'type'     => 'textarea',
                            'title'    => __( '[2] Text', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_detailed_second_info_title',
                            'type'     => 'text',
                            'title'    => __( '[2] Detailed Info Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'          => 'sk8er_detailed_second_info',
                            'type'        => 'slides',
                            'title'       => __( '[2] Detailed Info', 'sk8er' ),
                            'description' => __( '', 'sk8er'),
                            'subtitle'    => __( 'Go <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a>, choose icon you like, paste name here like this: <b>fa-university</b>', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Info Text', 'sk8er' ),
                                'description' => __( 'Icon Class', 'sk8er' ),
                                'url'         => __( 'Leave Empty.', 'sk8er' ),
                            ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Clients List', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-group',
                    'fields' => array(
                        array(
                            'id'       => 'sk8er_clients_title',
                            'type'     => 'text',
                            'title'    => __( 'Title', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'       => 'sk8er_clients_description',
                            'type'     => 'textarea',
                            'title'    => __( 'Description', 'sk8er' ),
                            'subtitle' => __( '', 'sk8er' ),
                            'desc'     => __( '', 'sk8er' ),
                        ),
                        array(
                            'id'          => 'sk8er_clients',
                            'type'        => 'slides',
                            'title'       => __( 'Clients', 'sk8er' ),
                            'description' => __( '', 'sk8er'),
                            'subtitle'    => __( 'Upload image and add link (optional).', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Client Name', 'sk8er' ),
                                'description' => __( 'Leave Empty.', 'sk8er' ),
                                'url'         => __( 'URL', 'sk8er' ),
                            ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Text With Image Section', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-photo',
                    'fields' => array(
                        array(
                            'id'       => 'sk8er_twis_image',
                            'type'     => 'media',
                            'title'    => __( 'Upload Image', 'sk8er' ),
                            'compiler' => 'true',
                            'mode'     => false,
                        ),
                        array(
                            'id' => 'sk8er_twis_image_pop',
                            'type' => 'select',
                            'title' => __( 'Pop Image?', 'sk8er' ),
                            'options' => array(
                                'no'    => 'Nope',
                                'up'    => 'Pop Up',
                                'down'  => 'Pop Down',
                            ),
                            'default' => 'no'
                        ),
                        array(
                            'id'          => 'sk8er_twis_text',
                            'type'        => 'slides',
                            'title'       => __( 'Text Block', 'sk8er' ),
                            'description' => __( 'Go <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a>, choose icon you like, paste name here like this: <b>fa-university</b>', 'sk8er'),
                            'subtitle'    => __( '', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Title', 'sk8er' ),
                                'description' => __( 'Description', 'sk8er' ),
                                'url'         => __( 'Icon Class', 'sk8er' ),
                            ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'List With Image Section', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-photo',
                    'fields' => array(
                        array(
                            'id'       => 'sk8er_lwis_image',
                            'type'     => 'media',
                            'title'    => __( 'Upload Image', 'sk8er' ),
                            'compiler' => 'true',
                            'mode'     => false,
                        ),
                        array(
                            'id' => 'sk8er_lwis_image_pop',
                            'type' => 'select',
                            'title' => __( 'Pop Image?', 'sk8er' ),
                            'options' => array(
                                'no'    => 'Nope',
                                'up'    => 'Pop Up',
                                'down'  => 'Pop Down',
                            ),
                            'default' => 'no'
                        ),
                        array(
                            'id'          => 'sk8er_lwis_text',
                            'type'        => 'slides',
                            'title'       => __( 'Text Block', 'sk8er' ),
                            'description' => __( 'Go <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a>, choose icon you like, paste name here like this: <b>fa-university</b>', 'sk8er'),
                            'subtitle'    => __( '', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Title', 'sk8er' ),
                                'description' => __( 'Leave Empty.', 'sk8er' ),
                                'url'         => __( 'Icon Class', 'sk8er' ),
                            ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Features Section', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-th-large',
                    'fields' => array(
                        array(
                            'id'          => 'sk8er_features_list',
                            'type'        => 'slides',
                            'title'       => __( 'Features', 'sk8er' ),
                            'description' => __( 'Upload Image and add Title.', 'sk8er'),
                            'subtitle'    => __( '', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Title', 'sk8er' ),
                                'description' => __( 'Leave Empty.', 'sk8er' ),
                                'url'         => __( 'Leave Empty.', 'sk8er' ),
                            ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'Listed Items Section', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-list',
                    'fields' => array(
                        array(
                            'id'          => 'sk8er_listed_items',
                            'type'        => 'slides',
                            'title'       => __( 'Listed Items', 'sk8er' ),
                            'description' => __( 'Upload Image or type icon name and add Title and description.', 'sk8er'),
                            'subtitle'    => __( 'Go <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">here</a>, choose icon you like, paste name here like this: <b>fa-university</b>', 'sk8er' ),
                            'placeholder' => array(
                                'title'       => __( 'Title', 'sk8er' ),
                                'description' => __( 'Description', 'sk8er' ),
                                'url'         => __( 'Icon name', 'sk8er' ),
                            ),
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'FAQ Section', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => 'el-icon-question-sign',
                    'fields' => array(
                         array(
                            'id' => 'sk8er_faq_secton_items',
                            'type' => 'multi_text',
                            'title' => __( 'FAQ List', 'sk8er' ),
                            'subtitle' => __( 'Write like this: <b>Question|Answer</b>. (You must include vertical line between question and answer)', 'sk8er' )
                        ),
                    ),
                );

                $this->sections[] = array(
                    'title'  => __( 'SVG Head Block', 'sk8er' ),
                    'desc'   => __( '', 'sk8er' ),
                    'icon'   => ' el-icon-slideshare',
                    'fields' => array(
                        array(
                            'id'       => 'sk8er_svg_head_background_image',
                            'type'     => 'media',
                            'title'    => __( 'Background Image', 'sk8er' ),
                            'compiler' => 'true',
                            'mode'     => false,
                        ),
                         array(
                             'id'       => 'sk8er_svg_head_title',
                             'type'     => 'text',
                             'title'    => __( 'Title', 'sk8er' ),
                             'subtitle' => __( '', 'sk8er' ),
                             'desc'     => __( '', 'sk8er' ),
                         ),
                         array(
                             'id'       => 'sk8er_svg_head_subtitle',
                             'type'     => 'text',
                             'title'    => __( 'Subtitle', 'sk8er' ),
                             'subtitle' => __( '', 'sk8er' ),
                             'desc'     => __( '', 'sk8er' ),
                         ),

                         array(
                             'id'       => 'sk8er_svg_head_code',
                             'type'     => 'textarea',
                             'title'    => __( 'SVG Code', 'sk8er' ),
                             'subtitle' => __( '', 'sk8er' ),
                             'desc'     => __( '', 'sk8er' ),
                         ),
                         array(
                             'id'       => 'sk8er_svg_head_image',
                             'type'     => 'media',
                             'title'    => __( 'Upload Image', 'sk8er' ),
                             'compiler' => 'true',
                             'mode'     => false,
                         ),
                         array(
                             'id'          => 'sk8er_svg_head_buttons',
                             'type'        => 'slides',
                             'title'       => __( 'Buttons', 'sk8er' ),
                             'description' => __( 'Upload Image or type icon name and add Title and description.', 'sk8er'),
                             'subtitle'    => __( '', 'sk8er' ),
                             'placeholder' => array(
                                 'title'       => __( 'Small Titlte', 'sk8er' ),
                                 'description' => __( 'Big Title', 'sk8er' ),
                                 'url'         => __( 'URL', 'sk8er' ),
                             ),
                         ),
                    ),
                );


                $this->sections[] = array(
                    'type' => 'divide',
                );

                $theme_info = '<div class="redux-framework-section-desc">';
                $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . __( '<strong>Theme URL:</strong> ', 'sk8er' ) . '<a href="' . $this->theme->get( 'ThemeURI' ) . '" target="_blank">' . $this->theme->get( 'ThemeURI' ) . '</a></p>';
                $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . __( '<strong>Author:</strong> ', 'sk8er' ) . $this->theme->get( 'Author' ) . '</p>';
                $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . __( '<strong>Version:</strong> ', 'sk8er' ) . $this->theme->get( 'Version' ) . '</p>';
                $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get( 'Description' ) . '</p>';
                $tabs = $this->theme->get( 'Tags' );
                if ( ! empty( $tabs ) ) {
                    $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . __( '<strong>Tags:</strong> ', 'sk8er' ) . implode( ', ', $tabs ) . '</p>';
                }
                $theme_info .= '</div>';

                if ( file_exists( dirname( __FILE__ ) . '/../README.md' ) ) {
                    $this->sections['theme_docs'] = array(
                        'icon'   => 'el-icon-list-alt',
                        'title'  => __( 'Documentation', 'sk8er' ),
                        'fields' => array(
                            array(
                                'id'       => '17',
                                'type'     => 'raw',
                                'markdown' => true,
                                'content'  => file_get_contents( dirname( __FILE__ ) . '/../README.md' )
                            ),
                        ),
                    );
                }

                $this->sections[] = array(
                    'title'  => __( 'Import / Export', 'sk8er' ),
                    'desc'   => __( 'Import and Export your Redux Framework settings from file, text or URL.', 'sk8er' ),
                    'icon'   => 'el-icon-refresh',
                    'fields' => array(
                        array(
                            'id'         => 'opt-import-export',
                            'type'       => 'import_export',
                            'title'      => 'Import Export',
                            'subtitle'   => 'Save and restore your Redux options',
                            'full_width' => false,
                        ),
                    ),
                );

                $this->sections[] = array(
                    'type' => 'divide',
                );

                $this->sections[] = array(
                    'icon'   => 'el-icon-info-sign',
                    'title'  => __( 'Theme Information', 'sk8er' ),
                    'desc'   => __( '<p class="description">This is the Description. Again HTML is allowed</p>', 'sk8er' ),
                    'fields' => array(
                        array(
                            'id'      => 'opt-raw-info',
                            'type'    => 'raw',
                            'content' => $item_info,
                        )
                    ),
                );

                if ( file_exists( trailingslashit( dirname( __FILE__ ) ) . 'README.html' ) ) {
                    $tabs['docs'] = array(
                        'icon'    => 'el-icon-book',
                        'title'   => __( 'Documentation', 'sk8er' ),
                        'content' => nl2br( file_get_contents( trailingslashit( dirname( __FILE__ ) ) . 'README.html' ) )
                    );
                }
            }

            public function setHelpTabs() {

                // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-1',
                    'title'   => __( 'Theme Information 1', 'sk8er' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'sk8er' )
                );

                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-2',
                    'title'   => __( 'Theme Information 2', 'sk8er' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'sk8er' )
                );

                // Set the help sidebar
                $this->args['help_sidebar'] = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'sk8er' );
            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'             => 'sk8er',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'         => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'      => $theme->get( 'Version' ),
                    // Version that appears at the top of your panel
                    'menu_type'            => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'       => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'           => __( 'Theme Options', 'sk8er' ),
                    'page_title'           => __( 'Theme Options', 'sk8er' ),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => true,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => true,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-portfolio',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => false,
                    // Show the time the page took to load, etc
                    'update_notice'        => true,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => 3,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'            => '',
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => '_options',
                    // Page slug used to denote the panel
                    'save_defaults'        => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'           => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'             => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'          => false,
                    // REMOVE

                    // HINTS
                    'hints'                => array(
                        'icon'          => 'icon-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );

                // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
                $this->args['admin_bar_links'][] = array(
                    'id'    => 'redux-docs',
                    'href'   => 'http://docs.reduxframework.com/',
                    'title' => __( 'Documentation', 'sk8er' ),
                );

                $this->args['admin_bar_links'][] = array(
                    //'id'    => 'redux-support',
                    'href'   => 'https://github.com/ReduxFramework/redux-framework/issues',
                    'title' => __( 'Support', 'sk8er' ),
                );

                $this->args['admin_bar_links'][] = array(
                    'id'    => 'redux-extensions',
                    'href'   => 'reduxframework.com/extensions',
                    'title' => __( 'Extensions', 'sk8er' ),
                );

                // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
                $this->args['share_icons'][] = array(
                    'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                    'title' => 'Visit us on GitHub',
                    'icon'  => 'el-icon-github'
                    //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                    'title' => 'Like us on Facebook',
                    'icon'  => 'el-icon-facebook'
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'http://twitter.com/reduxframework',
                    'title' => 'Follow us on Twitter',
                    'icon'  => 'el-icon-twitter'
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'http://www.linkedin.com/company/redux-framework',
                    'title' => 'Find us on LinkedIn',
                    'icon'  => 'el-icon-linkedin'
                );

                // Panel Intro text -> before the form
                if ( ! isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
                    if ( ! empty( $this->args['global_variable'] ) ) {
                        $v = $this->args['global_variable'];
                    } else {
                        $v = str_replace( '-', '_', $this->args['opt_name'] );
                    }
                    $this->args['intro_text'] = sprintf( __( '', 'sk8er' ), $v );
                } else {
                    $this->args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'sk8er' );
                }

                // Add content after the form.
                $this->args['footer_text'] = __( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'sk8er' );
            }

            public function validate_callback_function( $field, $value, $existing_value ) {
                $error = true;
                $value = 'just testing';

                /*
              do your validation

              if(something) {
                $value = $value;
              } elseif(something else) {
                $error = true;
                $value = $existing_value;

              }
             */

                $return['value'] = $value;
                $field['msg']    = 'your custom error message';
                if ( $error == true ) {
                    $return['error'] = $field;
                }

                return $return;
            }

            public function class_field_callback( $field, $value ) {
                print_r( $field );
                echo '<br/>CLASS CALLBACK';
                print_r( $value );
            }

        }

        global $reduxConfig;
        $reduxConfig = new Redux_Framework_sample_config();
    } else {
        echo "The class named Redux_Framework_sample_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ):
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    endif;

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ):
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error = true;
            $value = 'just testing';

            /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;

          }
         */

            $return['value'] = $value;
            $field['msg']    = 'your custom error message';
            if ( $error == true ) {
                $return['error'] = $field;
            }

            return $return;
        }
    endif;
