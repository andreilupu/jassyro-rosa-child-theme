<?php
/**
 * If you would like to overwrite the css of the theme you will need to uncomment this action
 */

add_action('wp_enqueue_scripts', 'load_child_theme_styles',1);

function load_child_theme_styles(){
	$theme = wp_get_theme();
	$parent = $theme->parent();

	wp_enqueue_style( 'rosaa-main-style', get_template_directory_uri() . '/style.css', array(), $parent->get( 'Version' ) );

	// Here we are adding the child style.css while still retaining
	// all of the parents assets (style.css, JS files, etc)
	// wp_enqueue_style( 'rosa-child-style',
	// 	get_stylesheet_directory_uri() . '/style.css',
	// 	//array('rosa-main-style'), //make sure the the child's style.css comes after the parents so you can overwrite rules
	// 	$parent->get( 'Version' )
	// );
}

/*
 * Function for displaying The Main Header Menu
 */
function wpgrade_first_page_main_nav() {
	// test if there are menu locations to prevent errors
	$theme_locations = get_nav_menu_locations();

	$args = array(
		'theme_location' => 'first_page_main_menu',
		'menu'           => '',
		'container'      => '',
		'container_id'   => '',
		'menu_class'     => 'nav  nav--main  nav--items-menu',
		'menu_id'        => '',
		'fallback_cb'    => 'wpgrade_please_select_a_menu',
		'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
	);

	wp_nav_menu( $args );
	//        }
}

function wpgrade_register_first_page_menus() {
	register_nav_menu( 'first_page_main_menu', 'First page' );
}

add_action( "after_setup_theme", "wpgrade_register_first_page_menus" );


function jassy_register_sidebars() {

	register_sidebar( array(
		'id'            => 'sidebar-footer-2',
		'name'          => __( 'Second Footer Area', 'rosa_txtd' ),
		'description'   => __( 'Second Footer Area', 'rosa_txtd' ),
		'before_title'  => '<h4 class="widget__title widget--menu__title">',
		'after_title'   => '</h4>',
		'before_widget' => '<div id="%1$s" class="widget widget--menu %2$s">',
		'after_widget'  => '</div>',
	) );

}

add_action( 'widgets_init', 'jassy_register_sidebars', 9999 );
/*
 * Load the translations from the child theme if present
 */
add_action( 'before_wpgrade_core', 'rosa_child_theme_setup' );
function rosa_child_theme_setup() {
	load_child_theme_textdomain( 'rosa_txtd', get_stylesheet_directory() . '/languages' );
}

function jassy_add_custom_favicon() {
	?>
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_stylesheet_directory_uri() . '/favicon' ;?>/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_stylesheet_directory_uri() . '/favicon' ;?>/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_stylesheet_directory_uri() . '/favicon' ;?>/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_stylesheet_directory_uri() . '/favicon' ;?>/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_stylesheet_directory_uri() . '/favicon' ;?>/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_stylesheet_directory_uri() . '/favicon' ;?>/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_stylesheet_directory_uri() . '/favicon' ;?>/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_stylesheet_directory_uri() . '/favicon' ;?>/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri() . '/favicon' ;?>/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_stylesheet_directory_uri() . '/favicon' ;?>/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_stylesheet_directory_uri() . '/favicon' ;?>/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_stylesheet_directory_uri() . '/favicon' ;?>/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_stylesheet_directory_uri() . '/favicon' ;?>/favicon-16x16.png">
<link rel="manifest" href="<?php echo get_stylesheet_directory_uri() . '/favicon' ;?>/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php echo get_stylesheet_directory_uri() . '/favicon' ;?>/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
	<?php
}

add_action('wp_head', 'jassy_add_custom_favicon');

// add a special class to the menu_pages
function jassy_add_class_to_menu_page( $classes, $class, $post_ID ) {

	if ( in_array($post_ID, array( "8", "99", "101", "119", "270" ) ) ) {
		$classes[] = 'jassy_menu_page';
	}
	return $classes;
}

add_filter('post_class', 'jassy_add_class_to_menu_page', 10, 3);

function add_customify_jassyro_options ( $config ) {


	 $new_opts = array(
		 'title'    => __( 'Menu page', 'customify_txtd' ),
		 'priority' => 1,
		 'description'            => __( 'Using the color pickers you can change the colors of the most important elements. If you want to override the color of some elements you can always use Custom CSS code in Theme Options - Custom Code.', 'rosa_txtd' ),
		 'options' => array(
			 'menu_page_color'   => array(
				 'type'      => 'color',
				 'label'     => __( 'Menu Color', 'customify_txtd' ),
				 'live' => true,
				 'default'   => '#dddddd',
				 'css'  => array(
					 array(
						 'property'     => 'color',
						 'selector' => 'html .jassy_menu_page *',
					 )
				 )
			 ),

			 'menu_page_background_color'   => array(
				 'type'      => 'color',
				 'label'     => __( 'Menu Page Background', 'customify_txtd' ),
				 'live' => true,
				 'default'   => '#000000',
				 'css'  => array(
					 array(
						 'property'     => 'background-color',
						 'selector' => '.jassy_menu_page .page .article__content,
								.jassy_menu_page .up-link,
								html .jassy_menu_page,
//								.jassy_menu_page .menu-list__item-title .item_title,
//								.jassy_menu_page .menu-list__item-title,
//								.jassy_menu_page .menu-list__item-price,
								.jassy_menu_page .desc__content',
					 )
				 )
			 ),

			 'menu_page_image_pattern'   => array(
				 'type'      => 'custom_background',
				 'label'     => __( 'Menu Page Background', 'customify_txtd' ),
				 'desc'      => __( 'Container background with image.', 'rosa_txtd' ),
				 'output'    => array( '.jassy_menu_page .article__content' ),
			 ),

			 'google_menu_page_font'     => array(
				 'type'    => 'typography',
				 'label'   => __( 'Body', 'customify_txtd' ),
				 'desc'       => __( 'Font for content and widget text.', 'rosa_txtd' ),
//								'default' => 'Cabin',
				 'recommended' => array(
					 'Cabin',
					 'Source Sans Pro',
					 'Herr Von Muellerhoff',
				 ),
				 'selector' => 'html body.jassy_menu_page p, html body.jassy_menu_page span, html body.jassy_menu_page h4, html body.jassy_menu_page h2',
				 'load_all_weights' => true,
			 ),
		 )
	 );


	$config['sections']['colors_section']['options']['container_image_pattern']['output'] = array( '.page .article__content, html, #page' );
	


	$config['sections']['menu_page_opts'] = $new_opts;

	return $config;
}

add_filter( 'customify_filter_fields', 'add_customify_jassyro_options', 15 );