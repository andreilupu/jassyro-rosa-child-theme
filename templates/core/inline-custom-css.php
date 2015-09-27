<?php

/**
 * Generate all the css declared in customizer's config
 * ====== DO NOT EDIT BELOW!!! =======
 * If you need to add custom css rules add them above so we can keep track of them
 */

$redux_sections = wpgrade::get_redux_sections();


/**
 *======= TYPOGRAPHY


$fonts = array();

if ( isset( $fonts['google_menu_page_font'] ) ) {
	// this needs a default
	$font_size = '14px'; ?>
	html body.jassy_menu_page p, html body.jassy_menu_page span, html body.jassy_menu_page h4, html body.jassy_menu_page h2 {
	<?php wpgrade::display_font_params( $fonts['google_menu_page_font'] ); ?>
	}
<?php }
 */
//handle the complicated logic of the footer waves that keeps changing color
$footer_sidebar_style    = wpgrade::option( 'footer_sidebar_style' );
$waves_fill_color = '#121212';
switch ($footer_sidebar_style) {
	case 'light' :
		$waves_fill_color = '#ffffff';
		break;
	case 'dark' :
		$waves_fill_color = '#121212';
		break;
	case 'accent' :
		$waves_fill_color = '#'.wpgrade::option('main-color');
		break;

}
?>
.site-footer.border-waves:before {
	background-image: url("data:image/svg+xml;utf8,<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' viewBox='0 0 19 14' width='19' height='14' enable-background='new 0 0 19 14' xml:space='preserve' preserveAspectRatio='none slice'><g><path fill='<?php echo $waves_fill_color ?>' d='M0,0c4,0,6.5,5.9,9.5,5.9S15,0,19,0v7H0V0z'/><path fill='<?php echo $waves_fill_color ?>' d='M19,14c-4,0-6.5-5.9-9.5-5.9S4,14,0,14l0-7h19V14z'/></g></svg>");
}
<?php


if (wpgrade::option('custom_css')) {
	echo wpgrade::option( 'custom_css' );
}