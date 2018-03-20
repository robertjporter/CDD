<?php
/**
 * _tk functions and definitions
 *
 * @package _tk
 */
 
 /**
  * Store the theme's directory path and uri in constants
  */
 define('THEME_DIR_PATH', get_template_directory());
 define('THEME_DIR_URI', get_template_directory_uri());

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 750; /* pixels */

if ( ! function_exists( '_tk_setup' ) ) :
/**
 * Set up theme defaults and register support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function _tk_setup() {
	global $cap, $content_width;

	// Add html5 behavior for some theme elements
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

    // This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	/**
	 * Add default posts and comments RSS feed links to head
	*/
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	*/
	add_theme_support( 'post-thumbnails' );

	/**
	 * Enable support for Post Formats
	*/
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	/**
	 * Setup the WordPress core custom background feature.
	*/
	add_theme_support( 'custom-background', apply_filters( '_tk_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
		) ) );
	
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on _tk, use a find and replace
	 * to change '_tk' to the name of your theme in all the template files
	*/
	load_theme_textdomain( '_tk', THEME_DIR_PATH . '/languages' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	*/
	register_nav_menus( array(
		'primary'  => __( 'Header bottom menu', '_tk' ),
		) );

}
endif; // _tk_setup
add_action( 'after_setup_theme', '_tk_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function _tk_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', '_tk' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
		) );
}
add_action( 'widgets_init', '_tk_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function _tk_scripts() {

	// Import the necessary TK Bootstrap WP CSS additions
	wp_enqueue_style( '_tk-bootstrap-wp', THEME_DIR_URI . '/includes/css/bootstrap-wp.css' );

	// load bootstrap css
	wp_enqueue_style( '_tk-bootstrap', THEME_DIR_URI . '/includes/resources/bootstrap/css/bootstrap.min.css' );

	// load Font Awesome css
	wp_enqueue_style( '_tk-font-awesome', THEME_DIR_URI . '/includes/css/font-awesome.min.css', false, '4.1.0' );

	// load _tk styles
	wp_enqueue_style( '_tk-style', get_stylesheet_uri() );

	// load bootstrap js
	wp_enqueue_script('_tk-bootstrapjs', THEME_DIR_URI . '/includes/resources/bootstrap/js/bootstrap.min.js', array('jquery') );

	// load bootstrap wp js
	wp_enqueue_script( '_tk-bootstrapwp', THEME_DIR_URI . '/includes/js/bootstrap-wp.js', array('jquery') );

	wp_enqueue_script( '_tk-skip-link-focus-fix', THEME_DIR_URI . '/includes/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( '_tk-keyboard-image-navigation', THEME_DIR_URI . '/includes/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

}
add_action( 'wp_enqueue_scripts', '_tk_scripts' );

/**
 * Implement the Custom Header feature.
 */
require THEME_DIR_PATH . '/includes/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require THEME_DIR_PATH . '/includes/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require THEME_DIR_PATH . '/includes/extras.php';

/**
 * Customizer additions.
 */
require THEME_DIR_PATH . '/includes/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require THEME_DIR_PATH . '/includes/jetpack.php';

/**
 * Load custom WordPress nav walker.
 */
require THEME_DIR_PATH . '/includes/bootstrap-wp-navwalker.php';

/**
 * Adds WooCommerce support
 */
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}


/* CUSTOM LOGIN STYLE */
function my_custom_login()
{
echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-style.css" />';
}
add_action('login_head', 'my_custom_login');


/* POINTS FUNCTIOALITY*/
    //Save points extra registration user meta.
    add_action( 'user_register', 'myplugin_user_register' );
    function myplugin_user_register( $user_id ) {
        update_user_meta( $user_id, 'user_points', 0 );
    }
	
	//Add points to admin pannel
	function theme_add_user_points_column( $columns ) {
		$columns['user_points'] = __( 'Dev Points', 'theme' );
		return $columns;
	}
	add_filter( 'manage_users_columns', 'theme_add_user_points_column' );
	
	//Show user points data
	function theme_show_user_points_data( $value, $column_name, $user_id ) {
		if( 'user_points' == $column_name ) {
			return get_user_meta( $user_id, 'user_points', true );
		}
	}
	add_action( 'manage_users_custom_column', 'theme_show_user_points_data', 10, 3 );

	
	//MY VERSION
	//Spend Points action
	add_action('wp_ajax_nopriv_dev-vote', 'dev_vote');
	add_action('wp_ajax_dev-vote', 'dev_vote');
	
	wp_enqueue_script('vote_dev', get_template_directory_uri().'/includes/js/dev-vote.js', array('jquery'), '1.0', true );
	wp_localize_script('vote_dev', 'ajax_var', array(
		'url' => admin_url('admin-ajax.php'),
		'nonce' => wp_create_nonce('ajax-nonce')
	));
	
	function dev_vote(){
		// Check for nonce security
		$nonce = $_POST['nonce'];
		$post_id = $_POST['post_id'];
		$user_ID = get_current_user_id();
		$user_dev_points = get_user_meta($user_ID, 'user_points', true);
		
		if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
			die ( 'Busted!');
		
		if(isset($_POST['dev_vote']))
		{
			if($user_dev_points>0){
				add_post_meta($post_id, "supporter_id", $user_ID);
				update_user_meta($user_ID, "user_points", $user_dev_points-1);
			}
		}
		exit;
	}
	
	function dev_remove(){
		// Check for nonce security
		$nonce = $_POST['nonce'];
		$post_id = $_POST['post_id'];
		$user_ID = get_current_user_id();
		$user_dev_points = get_user_meta($user_ID, 'user_points', true);
		
		if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
			die ( 'Busted!');
		
		if(isset($_POST['dev_vote']))
		{
			if($user_dev_points>0){
				add_post_meta($post_id, "supporter_id", $user_ID);
				update_user_meta($user_ID, "user_points", $user_dev_points-1);
			}
		}
		exit;
	}
	
	function getDevVoteLink($post_id)
	{
		$user_ID = get_current_user_id();
		$user_dev_points = get_user_meta($user_ID, 'user_points', true);
		$vote_count = count (get_post_meta($post_id, "supporter_id", false));
		
		$output .= "<br>This Feature has <span class='vote_count'>".$vote_count."</span> Dev-points<br>";
		
		if($user_ID){
			$output .= "You are user ".$user_ID." and you have <span class='user_dev_points'>".$user_dev_points."</span> Dev-points.";
			
			$output .= "<br><button data-post_id='".$post_id."' data-vote_count='".$vote_count."' data-user_dev_points='".$user_dev_points."' type='button' class='btn btn-success dev-vote'>Support With Dev Point.</button>";
			
			$output .= "<br><button data-post_id='".$post_id."' data-vote_count='".$vote_count."' data-user_dev_points='".$user_dev_points."' type='button' class='btn btn-info dev-vote'>Add Another Dev-Point.</button>";
			
			$output .= " <button data-post_id='".$post_id."' data-vote_count='".$vote_count."' data-user_dev_points='".$user_dev_points."' type='button' class='btn btn-danger dev-remove'>Remove One Dev-Point.</button>";
		} else { 
			$output .= "Please Login or Signup to vote.";
		}
		
		
		
		return $output;
	}
	
	
	//ROUND 2
	