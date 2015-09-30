<?php
/**
 * Kute Theme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package KuteTheme
 * @subpackage KuteTheme
 * @since Kute Theme 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Kute Theme 1.0
 */
 
define( 'THEME_DIR', trailingslashit(get_template_directory()));
define( 'THEME_URL', trailingslashit(get_template_directory_uri()));

if ( ! isset( $content_width ) ) {
	$content_width = 1170;
}

/**
 * Kute Theme only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require THEME_DIR . '/inc/back-compat.php';
}

if ( ! function_exists( 'kutetheme_setup' ) ) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     *
     * @since Kute theme 1.0.0
     */
    function kt_setup() {
    
    	/*
    	 * Make theme available for translation.
    	 * Translations can be filed in the /languages/ directory.
    	 * If you're building a theme based on kutetheme, use a find and replace
    	 * to change 'kutetheme' to the name of your theme in all the template files
    	 */
    	load_theme_textdomain( 'kutetheme', THEME_DIR . '/languages' );
    
    	// Add default posts and comments RSS feed links to head.
    	add_theme_support( 'automatic-feed-links' );
    
    	/*
    	 * Let WordPress manage the document title.
    	 * By adding theme support, we declare that this theme does not use a
    	 * hard-coded <title> tag in the document head, and expect WordPress to
    	 * provide it for us.
    	 */
    	add_theme_support( 'title-tag' );
    
    	/*
    	 * Enable support for Post Thumbnails on posts and pages.
    	 *
    	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
    	 */
    	add_theme_support( 'post-thumbnails' );
        
    	set_post_thumbnail_size( 825, 510, true );
    
    	// This theme uses wp_nav_menu() in two locations.
    	register_nav_menus( array(
    		'primary'   => __( 'Primary Menu', 'kutetheme' ),
    		'vertical'  => __( 'Vertical Menu', 'kutetheme' ),
    	) );
    
    	/*
    	 * Switch default core markup for search form, comment form, and comments
    	 * to output valid HTML5.
    	 */
    	add_theme_support( 'html5', array(
    		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    	) );
    
    	/*
    	 * Enable support for Post Formats.
    	 *
    	 * See: https://codex.wordpress.org/Post_Formats
    	 */
         /*
    	add_theme_support( 'post-formats', array(
    		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
    	) );
        */
    
    	$color_scheme  = kt_get_color_scheme();
    	$default_color = trim( $color_scheme[0], '#' );
    
    	// Setup the WordPress core custom background feature.
    	add_theme_support( 'custom-background', apply_filters( 'kt_custom_background_args', array(
    		'default-color'      => $default_color,
    		'default-attachment' => 'fixed',
    	) ) );
    
    	/*
    	 * This theme styles the visual editor to resemble the theme style,
    	 * specifically font, colors, icons, and column width.
    	 */
    	add_editor_style( THEME_URL . 'css/editor-style.css' );
        add_image_size ( 'kt-post-thumb', 345, 244, true );
        add_image_size ( 'kt-post-thumb-small', 70, 49, true );
        add_image_size ( 'kt_post_blog_268x255', 268, 255, true );
    }
endif; // kt_setup
add_action( 'after_setup_theme', 'kt_setup' );

/**
 * Register widget area.
 *
 * @since Kute Theme 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
if( ! function_exists( 'kt_widgets_init' ) ){
    function kt_widgets_init() {
    	register_sidebar( array(
    		'name'          => __( 'Widget Area', 'kutetheme' ),
    		'id'            => 'sidebar-primary',
    		'description'   => __( 'Add widgets here to appear in your sidebar.', 'kutetheme' ),
    		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</aside>',
    		'before_title'  => '<h2 class="widget-title">',
    		'after_title'   => '</h2>',
    	) );
    	register_sidebar( array(
    		'name'          => __( 'Widget Shop Area', 'kutetheme' ),
    		'id'            => 'sidebar-shop',
    		'description'   => __( 'Add widgets here to appear in your sidebar.', 'kutetheme' ),
    		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</aside>',
    		'before_title'  => '<h2 class="widget-title">',
    		'after_title'   => '</h2>',
    	) );
    	
    	register_sidebar( array(
    		'name'          => __( 'Widget Shop single Area', 'kutetheme' ),
    		'id'            => 'sidebar-shop-single',
    		'description'   => __( 'Add widgets here to appear in your sidebar.', 'kutetheme' ),
    		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</aside>',
    		'before_title'  => '<h2 class="widget-title">',
    		'after_title'   => '</h2>',
    	) );
        
        
        register_sidebar( array(
            'name'          => __( 'Footer Menu 1', 'kutetheme'),
            'id'            => 'footer-menu-1',
            'description'   => __( 'The footer menu 1 widget area', 'kutetheme'),
            'before_widget' => '<div id="%1$s" class="widget-container widget-footer-menu %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title introduce-title">',
            'after_title'   => '</h3>',
        ) );
        
        register_sidebar( array(
            'name'          => __( 'Footer Menu 2', 'kutetheme'),
            'id'            => 'footer-menu-2',
            'description'   => __( 'The footer menu 2 widget area', 'kutetheme'),
            'before_widget' => '<div id="%1$s" class="widget-container widget-footer-menu %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title introduce-title">',
            'after_title'   => '</h3>',
        ) );
        
        register_sidebar( array(
            'name'          => __( 'Footer Menu 3', 'kutetheme'),
            'id'            => 'footer-menu-3',
            'description'   => __( 'The footer menu 3 widget area', 'kutetheme'),
            'before_widget' => '<div id="%1$s" class="widget-container widget-footer-menu %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title introduce-title">',
            'after_title'   => '</h3>',
        ) );
        
        register_sidebar( array(
            'name'          => __( 'Footer Social', 'kutetheme'),
            'id'            => 'footer-social',
            'description'   => __( 'The footer social widget area', 'kutetheme'),
            'before_widget' => '<div id="%1$s" class="widget-container widget-footer-social %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title introduce-title">',
            'after_title'   => '</h3>',
        ) );
        
        register_sidebar( array(
            'name'          => __( 'Footer Payment', 'kutetheme'),
            'id'            => 'footer-payment',
            'description'   => __( 'The footer payment widget area', 'kutetheme'),
            'before_widget' => '<div id="%1$s" class="widget-container widget-footer-payment %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title introduce-title">',
            'after_title'   => '</h3>',
        ) );
        
        register_sidebar( array(
            'name'          => __( 'Footer Bottom', 'kutetheme'),
            'id'            => 'footer-bottom',
            'description'   => __( 'The footer bottom widget area', 'kutetheme'),
            'before_widget' => '<div id="%1$s" class="widget-container widget-footer-bottom %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
        
        register_sidebar( array(
            'name'          => __( 'Footer Menu Bottom', 'kutetheme'),
            'id'            => 'footer-menu-bottom',
            'description'   => __( 'The footer menu bottom widget area', 'kutetheme'),
            'before_widget' => '<div id="%1$s" class="widget-container footer-menu-list widget-footer-menu-bottom %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
        // Custom widget
        $kt_group_sidebar = kt_option('kt_group_sidebar');
    	if($kt_group_sidebar){
    		$i=0;
    		foreach($kt_group_sidebar as $sidebar){
    			$i++;
    			register_sidebar( array(
    		        'name'          => $sidebar['title'],
    		        'id'            => 'kt-custom-sidebar-'.$i,
    		        'description'   => $sidebar['description'],
    		        'before_widget' => '<div id="%1$s" class="widget-container footer-menu-list widget-footer-menu-bottom %2$s">',
    		        'after_widget'  => '</div>',
    		        'before_title'  => '<h3 class="widget-title">',
    		        'after_title'   => '</h3>',
    		    ) );
    		}
    	}
        
    }
}
add_action( 'widgets_init', 'kt_widgets_init' );



/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Kute Theme 1.1
 */
if( ! function_exists( 'kt_javascript_detection' ) ){
    function kt_javascript_detection() {
    	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
    }
}

add_action( 'wp_head', 'kt_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 *
 * @since Kute Theme 1.0
 */
if( ! function_exists( 'kt_scripts' ) ){
    function kt_scripts() {
    	// Add custom fonts, used in the main stylesheet.
    
    	// Load the Internet Explorer specific stylesheet.
    	wp_enqueue_style( 'kt-ie', get_template_directory_uri() . '/css/ie.css', array( 'kt-style' ), '1.0' );
    	wp_style_add_data( 'kt-ie', 'conditional', 'lt IE 9' );
    
    	// Load reset default setting browser
    	wp_enqueue_style( 'kt-reset', get_template_directory_uri() . '/css/reset.css', array( ), '1.0' );
        
        wp_enqueue_style( 'kt-responsive', get_template_directory_uri() . '/css/responsive.css', array( ), '1.0' );
        
        wp_enqueue_style( 'kt-animate', get_template_directory_uri() . '/css/animate.css', array( ), '1.0' );
        
        wp_enqueue_style( 'kt-bootstrap', get_template_directory_uri() . '/libs/bootstrap/css/bootstrap.min.css' );
        
        wp_enqueue_style( 'kt-font-awesome', get_template_directory_uri() . '/libs/font-awesome/css/font-awesome.min.css' );
        
        wp_enqueue_style( 'kt-carousel', get_template_directory_uri() . '/libs/owl.carousel/owl.carousel.css' );
        
        wp_enqueue_style( 'kt-fancyBox', get_template_directory_uri() . '/libs/fancyBox/jquery.fancybox.css' );
        
        wp_enqueue_style( 'kt-jquery-ui', get_template_directory_uri() . '/libs/jquery-ui/jquery-ui.css' );
        wp_enqueue_style( 'kt-style', get_template_directory_uri() . '/css/style.css', 
            array( 
                'kt-bootstrap', 
                'kt-reset', 
                'kt-responsive', 
                'kt-animate',
                'kt-font-awesome',
                'kt-jquery-ui'
            ), '1.0' );
            // Load our main stylesheet.
    	wp_enqueue_style( 'kutetheme-style', get_stylesheet_uri(),array('kt-style') );
        
    	wp_enqueue_style( 'kt-custom-woocommerce-style', get_template_directory_uri().'/css/woocommerce.css',array('kt-style') );
    	
        wp_enqueue_style( 'kt-custom-vc-style', get_template_directory_uri().'/css/vc.css',array('kt-style') );
    	
        wp_enqueue_style( 'kt-responsive-style', get_template_directory_uri().'/css/responsive.css',array('kt-style') );
                
        wp_enqueue_style( 'kt-option-6', get_template_directory_uri() . '/css/option6.css', array('kt-style') );
        
        wp_enqueue_style( 'kt-option-2', get_template_directory_uri() . '/css/option2.css', array('kt-style') );
        
    	wp_enqueue_script( 'kt-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20141010', true );
    
    	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    		wp_enqueue_script( 'comment-reply' );
    	}
    
    	if ( is_singular() && wp_attachment_is_image() ) {
    		wp_enqueue_script( 'kt-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
    	}
        
        wp_enqueue_script( 'kt-bootstrap', get_template_directory_uri() . '/libs/bootstrap/js/bootstrap.min.js', array( 'jquery' ), '20150929', true );
        
        wp_enqueue_script( 'kt-carousel', get_template_directory_uri() . '/libs/owl.carousel/owl.carousel.js', array( 'jquery' ), '20150929', true );
        
        wp_enqueue_script( 'kt-fancyBox', get_template_directory_uri() . '/libs/fancyBox/jquery.fancybox.js', array( 'jquery' ), '20150929', true );
            
        wp_enqueue_script( 'kt-jquery-ui', get_template_directory_uri() . '/libs/jquery-ui/jquery-ui.min.js', array( 'jquery' ), '20150929', true );
        
        wp_enqueue_script( 'kt-actual', get_template_directory_uri() . '/js/jquery.actual.min.js', array( 'jquery' ), '20150929',true );
        
    	wp_enqueue_script( 'kt-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150929', true );
    
    	wp_enqueue_script( 'kt-count-down-plugin', get_template_directory_uri() . '/libs/countdown/jquery.plugin.js', array( 'jquery' ), '20150929', true );
    	wp_enqueue_script( 'kt-count-down-jq', get_template_directory_uri() . '/libs/countdown/jquery.countdown.js', array( 'jquery' ), '20150929', true );
        
    
        
    	wp_localize_script( 'kt-script', 'screenReaderText', array(
    		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'kutetheme' ) . '</span>',
    		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'kutetheme' ) . '</span>',
            
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'security' => wp_create_nonce( 'screenReaderText' ),
            'current_date' => date_i18n('Y-m-d H:i:s')
    	) );
    
    }
}

add_action( 'wp_enqueue_scripts', 'kt_scripts' );


add_action( 'admin_enqueue_scripts', 'kt_enqueue_script' );
if( ! function_exists("kt_enqueue_script")){
    function kt_enqueue_script(){
        wp_register_style( 'framework-core', THEME_URL.'css/framework-core.css');
        wp_enqueue_style( 'framework-core');
        
        wp_enqueue_script( 'kt_image', THEME_URL.'js/kt_image.js', array('jquery'), '1.0.0', true);
        
        wp_localize_script( 'kt_image', 'kt_image_lange', array(
            'frameTitle' => __( 'Select your image', 'kutetheme' )
        ));                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              
        
        wp_register_script( 'framework-core', THEME_URL.'js/framework-core.js', array('jquery', 'jquery-ui-tabs'), '1.0.0', true);
        wp_enqueue_script('framework-core');
        
        wp_enqueue_media();
    }
}

/**
 * Display descriptions in main navigation.
 *
 * @since Kute Theme 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
if( ! function_exists( 'kt_nav_description' )){
    function kt_nav_description( $item_output, $item, $depth, $args ) {
    	if ( 'primary' == $args->theme_location && $item->description ) {
    		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
    	}
    
    	return $item_output;
    }
} 

add_filter( 'walker_nav_menu_start_el', 'kt_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Kute Theme 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
if( ! function_exists( 'kt_search_form_modify' ) ){
    function kt_search_form_modify( $html ) {
    	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
    }
}

add_filter( 'get_search_form', 'kt_search_form_modify' );

/**
 * Implement the Custom Header feature.
 *
 * @since Kute Theme 1.0
 */
require THEME_DIR . '/inc/custom-header.php';

/**
 * Implement the Custom breadcrumbs.
 *
 * @since Kute Theme 1.0
 */
require THEME_DIR . '/inc/breadcrumbs.php';

/**
 * Custom template tags for this theme.
 *
 * @since Kute Theme 1.0
 */
//require THEME_DIR . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Kute Theme 1.0
 */
require THEME_DIR . '/inc/customizer.php';

/**
 * Function utility
 * */
require THEME_DIR . '/inc/utility.php';

/**
 * hooks action 
 * */

require THEME_DIR . '/inc/hooks/theme.php';

if( kt_is_wc() ){
    require THEME_DIR . '/inc/hooks/woocommerce.php';
}

/*if( kt_is_vc() ){
    require THEME_DIR . '/js_composer/visualcomposer.php';
}*/
if( ! class_exists( 'wp_bootstrap_navwalker' ) && file_exists( THEME_DIR. 'inc/nav/wp_bootstrap_navwalker.php' ) ){
    require_once( THEME_DIR. 'inc/nav/wp_bootstrap_navwalker.php' );
}
if( ! class_exists( 'KT_MEGAMENU' ) && file_exists( THEME_DIR. 'inc/nav/nav.php' ) ){
    require_once( THEME_DIR. 'inc/nav/nav.php' );
}

/**
 * Widgets
 */
require THEME_DIR . '/inc/widgets.php';
/**
 * Custom excerpt_more text 
**/
if( ! function_exists( 'kt_custom_excerpt_more' ) ){
    function kt_custom_excerpt_more( $more ) {
    	return '';
    }
}

add_filter('excerpt_more', 'kt_custom_excerpt_more');


/**
 * Custom display result blog
**/
if( ! function_exists( 'kt_display_result_post' ) ){
    function kt_display_result_post(){
        global $wp_query;
        ?>
        <span class="results-count">
            <?php _e('Showing', 'kutetheme' );?> 
            <?php $num = $wp_query->post_count; if ( have_posts()) : echo intval($num); endif;?> <?php _e( 'of', 'kutetheme' );?> <?php echo intval( $wp_query->found_posts );?> <?php _e('posts', 'kutetheme' );?> </h2>
        </span>
        <?php
    }
}


if( ! function_exists( 'kt_list_cats' ) ){
    function kt_list_cats( $num ){
    	$temp       = get_the_category();
        
    	$cat_string = "";
        
    	$count      = count( $temp );// Getting the total number of categories the post is filed in.
        
    	for( $i = 0; $i < $num && $i < $count; $i++ ){
    	   //Formatting our output.
        	$cat_string .= '<a href="' . esc_url( get_category_link( $temp[$i]->cat_ID ) ) . '">' . esc_html( $temp[$i]->cat_name ) . '</a>';
        	
            if( $i != $num - 1 && $i + 1 < $count)
        		$cat_string .= ', ';
    	}
        $allowed_html = array(
            'a' => array(
                'href' => array (),
                'title' => array ()
            )
        );
        echo wp_kses( $cat_string, $allowed_html );
    }
}
