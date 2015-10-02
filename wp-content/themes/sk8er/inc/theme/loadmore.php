<?php
// enqueue_scripts: make sure to include ajaxurl, so we know where to send the post request
function dt_add_main_js(){
  
  wp_register_script( 'sk8er-loadmore', get_template_directory_uri() . '/js/loadmore.js', array(), '1', true);
  wp_enqueue_script( 'sk8er-loadmore' );
  wp_localize_script( 'sk8er-loadmore', 'headJS', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'templateurl' => get_template_directory_uri(), 'posts_per_page' => get_option('posts_per_page') ) );
  
}
add_action( 'wp_enqueue_scripts', 'dt_add_main_js', 90);


add_action( "wp_ajax_load_more", "load_more_func" ); // when logged in
add_action( "wp_ajax_nopriv_load_more", "load_more_func" );//when logged out 
//function return new posts based on offset and posts per page value
function load_more_func() {
  //verifying nonce here
    if ( !wp_verify_nonce( $_REQUEST['nonce'], "load_posts" ) ) {
      exit("No naughty business please");
    }     
  $offset = isset($_REQUEST['offset'])?intval($_REQUEST['offset']):0;
  $posts_per_page = isset($_REQUEST['posts_per_page'])?intval($_REQUEST['posts_per_page']):10;
  //optional, if post type is not defined use regular post type
  $post_type = isset($_REQUEST['post_type'])?$_REQUEST['post_type']:'post';
  
  
  ob_start(); // buffer output instead of echoing it
  $args = array(
	  			'post_type'=>$post_type,
				'offset' => $offset,
				'posts_per_page' => $posts_per_page,
				'orderby' => 'date',
				'order' => 'DESC'
					);
  $posts_query = new WP_Query( $args );

  
  if ($posts_query->have_posts()) {
    global $post;
	  //if we have posts:
		  $result['have_posts'] = true; //set result array item "have_posts" to true
		  
		  while ( $posts_query->have_posts() ) : $posts_query->the_post(); ?>

    			<?php $current_category = wp_get_object_terms( $post->ID, 'portfolio-categories', array('orderby'=>'term_order')); ?>
            <?php if (has_post_thumbnail( $post->ID ) ): ?>
                <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                <?php $thumbnail = $image[0]; ?>
            <?php else: ?>
                <?php $thumbnail = "http://placehold.it/800x480&text=Portfolio+Image"; ?>
            <?php endif; ?>
            
            <div <?php post_class("item ".$current_category[0]->slug); ?>>
                <div class="image">
                    <div class="actual-image" style="background-image: url(<?php echo esc_url($thumbnail); ?>);"></div>
                    <div class="hover">
                        <div class="title"><?php the_title(); ?></div>
                        <div class="actions">
                            <!--<a href="<?php /*the_permalink(); */?>"><i class="fa fa-chain"></i></a>
                                <span class="sep"></span>-->
                            <a href="<?php echo esc_url($thumbnail); ?>" class="swipebox"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                </div>
                <div class="info">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <span><?php print_r($current_category[0]->name); ?></span>
                      <?php the_excerpt(); ?>
                </div>
            </div>

			<?php endwhile;
		$result['html'] = ob_get_clean(); // put alloutput data into "html" item
  } else {
	  //no posts found
	  $result['have_posts'] = false; // return that there is no posts found
  } 
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $result = json_encode($result); // encode result array into json feed
            echo $result; // by echo we return JSON feed on POST request sent via AJAX
        }
        else { 
            header("Location: ".$_SERVER["HTTP_REFERER"]);
        }
  die();
}
?>