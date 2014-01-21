<?php
/*
Plugin Name: Matty Theme QuickSwitch
Plugin URI: http://matty.co.za/
Description: Adds a quick theme switcher to the WordPress Admin Bar, aimed at speeding up rapid theme switching during theme development and maintenance.
Author: Matty
Author URI: http://matty.co.za/
Version: 1.0.0
Stable tag: 1.0.0
License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

if ( is_admin() ) {
	add_action( 'admin_bar_menu', 'matty_theme_quickswitch_menu', 1010 );
	add_action( 'admin_print_styles', 'matty_theme_quickswitch_css', 10 );
}

/**
 * matty_theme_quickswitch_menu function.
 * 
 * @access public
 * @return void
 */
function matty_theme_quickswitch_menu () {
	global $wp_admin_bar, $current_user;

	if ( ! current_user_can( 'switch_themes' ) ) { return; }

    $current_user_id = $current_user->user_login;
	
	$themes = get_themes();
	$current_theme = get_theme_data( get_stylesheet_directory() . '/style.css' );
	$count = 0;
	
	$menu_id = 'matty-theme-quickswitch';
	$menu_label = $current_theme['Name'];

	if ( ! isset( $themes  ) || ! is_array( $themes ) ) { return; } 

	// Main Menu Item
	$wp_admin_bar->add_menu( array( 'id' => $menu_id, 'title' => $menu_label, 'href' => '#' ) );
	
	// Theme List
	foreach ( $themes as $k => $v ) {
		$count++;
		
		$template = $v['Template'];
		$stylesheet = $v['Stylesheet'];
		$id = urlencode( str_replace( '/', '-', strtolower( $template ) ) );
		$activate_link = wp_nonce_url( 'themes.php?action=activate&amp;template=' . urlencode( $template ) . '&amp;stylesheet=' . urlencode( $stylesheet ), 'switch-theme_' . $template );
	
		$wp_admin_bar->add_menu( array( 'parent' => 'matty-theme-quickswitch', 'id' => 'theme-' . $id, 'title' => $v['Name'], 'href' => $activate_link ) );
	}
} // End matty_theme_quickswitch_menu()

/**
 * matty_theme_quickswitch_css function.
 * 
 * @access public
 * @return void
 */
function matty_theme_quickswitch_css () {
	if ( ! current_user_can( 'switch_themes' ) ) { return; }
?>
<style type="text/css">
	#wpwrap { min-height: none !important; }
	#wpadminbar #wp-admin-bar-matty-theme-quickswitch { float: right; }
	#wpadminbar #wp-admin-bar-matty-theme-quickswitch .ab-sub-wrapper { height: 500px; overflow-y: auto !important; overflow-x: hidden !important; right: 0; left: auto; }
</style>
<?php
} // End matty_theme_quickswitch_css()
?>