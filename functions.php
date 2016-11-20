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

function jassy_add_classes_to_body( $classes ) {

	if ( is_woocommerce() || is_product() ) {
		$classes[] = 'woocommerce jassy_menu_page';
		$classes[] = 'woocommerce-page  header--transparent';
	}

	elseif ( is_checkout() ) {
		$classes[] = 'woocommerce-checkout jassy_menu_page';
		$classes[] = 'woocommerce-page';
	}

	elseif ( is_cart() ) {
		$classes[] = 'woocommerce-cart jassy_menu_page';
		$classes[] = 'woocommerce-page';
	}

	elseif ( is_account_page() ) {
		$classes[] = 'woocommerce-account jassy_menu_page';
		$classes[] = 'woocommerce-page';
	}

	if ( is_store_notice_showing() ) {
		$classes[] = 'woocommerce-demo-store jassy_menu_page';
	}

	foreach ( WC()->query->query_vars as $key => $value ) {
		if ( is_wc_endpoint_url( $key ) ) {
			$classes[] = 'jassy_menu_page woocommerce-' . sanitize_html_class( $key );
		}
	}

	return $classes;
}

add_filter('body_class', 'jassy_add_classes_to_body', 10, 3);

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
						 'selector' => 'html .jassy_menu_page *, body.woocommerce.jassy_menu_page .header--transparent .nav--main a,
						 body.woocommerce.jassy_menu_page .nav--main a, body.woocommerce.jassy_menu_page .headroom--not-top .nav--main a,
						body.woocommerce.jassy_menu_page .nav--main a, body.woocommerce.jassy_menu_page .headroom--not-top .nav--main a,
						body.woocommerce.jassy_menu_page .nav.nav--items-social a:before,
						body.woocommerce.jassy_menu_page .headroom--not-top .nav.nav--items-social a:before',
					 ),
					 array(
					 	'property'     => 'border-color',
					 	'selector' => 'body.woocommerce.jassy_menu_page .article__content img'
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
				 'output'    => array( '.jassy_menu_page .article__content, body.jassy_menu_page div.site-header,
				  body.jassy_menu_page div.site-header.header--inversed, .value select, .quantity input.input-text.qty' ),
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

	$config['sections']['style_presets'] = array(
		'title'   => '&#x1f3ad; ' . esc_html__( 'Style Presets', 'rosa' ),
		'options' => array(
			'theme_style' => array(
				'type'         => 'preset',
				'label'        => __( 'Select a style:', 'rosa' ),
				'desc'         => __( 'Conveniently change the design of your site with built-in style presets. Easy as pie.', 'rosa' ),
				'default'      => 'rosa',
				'choices_type' => 'awesome',
				'choices'      => array(
					'rosa'  => array(
						'label'   => __( 'Rosa', 'rosa' ),
						'preview' => array(
							'color-text'       => '#ffffff',
							'background-card'  => '#ff4d55',
							'background-label' => '#f13d46',
							'font-main'        => 'Hanken',
							'font-alt'         => 'Source Sans Pro',
						),
						'options' => array(

							// COLORS
							'main_color'                 => 'red',
							'menu_page_color'                 => 'red',

							// FONTS
							'google_titles_font' => array(
								'font_family'       => 'Alice'
							),

							// FONTS
							'google_menu_page_font' => array(
								'font_family'       => 'Alice'
							),
//							'site_title_font_size'        => '24',
//							'site_title_text_transform'   => 'None',
//							'site_title_letter-spacing'   => '0',
//
//							'navigation_font'           => array(
//								'font_family'       => 'Hanken',
//								'selected_variants' => '400'
//							),
//							'navigation_font_size'      => '14.95',
//							'navigation_text_transform' => 'Capitalize',
//							'navigation_letter-spacing' => '0',
//
//							'body_font'        => array( 'font_family' => 'Source Sans Pro', 'selected_variants' => 'regular' ),
//							'page_titles_font'    => array( 'font_family' => 'Hanken', 'selected_variants' => '700' ),
//							'page_subtitles_font' => array( 'font_family'       => 'Hanken', 'selected_variants' => '400' ),
//							'meta_font'        => array( 'font_family'       => 'Hanken', 'selected_variants' => '400' ),
//							'card_font'        => array( 'font_family'       => 'Hanken', 'selected_variants' => '400' ),
//
//							'card_title_font'           => array( 'font_family'       => 'Hanken', 'selected_variants' => '700' ),
//							'card_title_font_size'      => '24',
//							'card_title_text_transform' => 'None',
//							'card_title_letter-spacing' => '0',

						)
					),


					// Eater Preset
					'royal' => array(
						'label'   => __( 'Eater', 'rosa' ),
						'preview' => array(
							'color-text'       => 'red',
							'background-card'  => '#000',
							'background-label' => '#333',
							'font-main'        => 'Eater',
							'font-alt'         => 'Eater',
						),
						'options' => array(
							'main_color'                 => 'red',
							'menu_page_color'                 => 'red',

							// FONTS
							'google_titles_font' => array(
								'font_family'       => 'Eater'
							),

							// FONTS
							'google_menu_page_font' => array(
								'font_family'       => 'Eater'
							),

							'google_subtitles_font' => array(
								'font_family'       => 'Eater'
							),

							'google_nav_font' => array(
								'font_family'       => 'Eater'
							),
						)
					),


					// Bloody Preset
					'bloody' => array(
						'label'   => __( 'Bloody', 'rosa' ),
						'preview' => array(
							'color-text'       => '#8A0707',
							'background-card'  => '#000',
							'background-label' => '#333',
							'font-main'        => 'Nosifer',
							'font-alt'         => 'Nosifer',
						),
						'options' => array(
							'main_color'                 => '#8A0707',
							'headings_color'                 => '#8A0707',
							'navlink_color'                 => '#8A0707',
							'cover_text'                 => '#8A0707',
							'menu_page_color'                 => '#896363',

							'header_background_color'                 => '#ed8a00',
							'content_background_color'                 => '#c980a5',

							// FONTS
							'google_titles_font' => array(
								'font_family'       => 'Nosifer'
							),

							// FONTS
							'google_body_font' => array(
								'font_family'       => 'Griffy'
							),

							'google_menu_page_font' => array(
								'font_family'       => 'Nosifer'
							),

							'google_subtitles_font' => array(
								'font_family'       => 'Nosifer'
							),

							'google_nav_font' => array(
								'font_family'       => 'Nosifer'
							),

							'nav_font-size' => 18,
							'nav_letter-spacing' => 1,
							'nav_text-decoration' => 'none',
						)
					),
				)
			),
		)
	);

	$config['sections']['menu_page_opts'] = $new_opts;

	// hook the color
	$config['sections']['colors_section']['options']['main_color']['css'][0]['selector'] .= '.woocommerce.jassy_menu_page .woocommerce-variation.single_variation';

	// hook the background-color
	$config['sections']['colors_section']['options']['main_color']['css'][1]['selector'] .= ' .woocommerce.jassy_menu_page #respond input#submit.alt,
	 .woocommerce.jassy_menu_page a.button.alt, .woocommerce.jassy_menu_page button.button.alt, .woocommerce.jassy_menu_page input.button.alt,
	 .woocommerce.jassy_menu_page button.button.alt.disabled, .woocommerce.jassy_menu_page button.button.alt.disabled:hover';


	return $config;
}

add_filter( 'customify_filter_fields', 'add_customify_jassyro_options', 15 );


add_action( 'pre_get_posts', 'custom_pre_get_posts_query' );

function custom_pre_get_posts_query( $q ) {

	if ( ! $q->is_main_query() ) return;
	if ( ! $q->is_post_type_archive() ) return;

	if ( ! is_admin() && is_shop() ) {

		$q->set( 'tax_query', array(array(
			'taxonomy' => 'product_cat',
			'field' => 'slug',
			'terms' => array( 'variatii' ), // Don't display products in the knives category on the shop page
			'operator' => 'NOT IN'
		)));

	}

	remove_action( 'pre_get_posts', 'custom_pre_get_posts_query' );

}

// remove things from woo

add_filter('wc_product_enable_dimensions_display', '__return_false', 99 );

function jassyro_play_with_single_product_tabs( $tabs ) {
	unset($tabs['reviews']);
	unset($tabs['additional_information']);
	return $tabs;
}

add_filter('woocommerce_product_tabs', 'jassyro_play_with_single_product_tabs' );

function woocommerce_template_single_meta() {
	// aha
}