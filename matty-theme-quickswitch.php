<?php
/*
Plugin Name: Matty Theme QuickSwitch
Plugin URI: http://matty.co.za/
Description: Adds a quick theme switcher to the WordPress Admin Bar, aimed at speeding up rapid theme switching during theme development and maintenance.
Author: Matty
Author URI: http://matty.co.za/
Version: 1.2.1
Stable tag: 1.2.1
License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

if ( is_admin() ) {
	add_action( 'admin_bar_menu', 'matty_theme_quickswitch_menu', 1010 );
	add_action( 'admin_print_styles', 'matty_theme_quickswitch_css', 10 );
	add_action( 'admin_enqueue_scripts', 'matty_theme_quickswitch_js', 10 );
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
	$themes = get_themes();
	$child_themes = array();
	$parent_themes = array();
	$current_theme = get_theme_data( get_stylesheet_directory() . '/style.css' );
	$count = 0;
	$has_child_themes = false;
	$end_child_themes = false;
	
	$menu_id = 'matty-theme-quickswitch';
	$menu_label = $current_theme['Name'];

	if ( ! isset( $themes  ) || ! is_array( $themes ) ) { return; } 

	// Main Menu Item
	$wp_admin_bar->add_menu( array( 'id' => $menu_id, 'title' => $menu_label, 'href' => '#' ) );

	foreach ( $themes as $k => $v ) {
		if ( $v['Template'] != $v['Stylesheet'] ) {
			$child_themes[] = $v;
		} else {
			$parent_themes[] = $v;
		}
	}

	if ( count( $child_themes ) > 0 ) {
		$has_child_themes = true;
	}

	$themes = array_merge( $child_themes, $parent_themes );

	if ( $has_child_themes ) {
		$wp_admin_bar->add_menu( array( 'parent' => 'matty-theme-quickswitch', 'id' => 'heading-child-themes', 'title' => __( 'Child Themes', 'matty-theme-quickswitch' ), 'href' => '#' ) );
	}

	// Theme List
	foreach ( $themes as $k => $v ) {
		$count++;
		
		$template = $v['Template'];
		$stylesheet = $v['Stylesheet'];
		$id = urlencode( str_replace( '/', '-', strtolower( $stylesheet ) ) );
		$activate_link = wp_nonce_url( 'themes.php?action=activate&amp;template=' . urlencode( $template ) . '&amp;stylesheet=' . urlencode( $stylesheet ), 'switch-theme_' . $template );
	
		if ( $has_child_themes == true && $end_child_themes == false && $template == $stylesheet ) {
			$wp_admin_bar->add_menu( array( 'parent' => 'matty-theme-quickswitch', 'id' => 'heading-parent-themes', 'title' => __( 'Parent Themes', 'matty-theme-quickswitch' ), 'href' => '#' ) );

			$end_child_themes = true;
		}

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

	$plugin_url = trailingslashit( plugins_url( dirname( plugin_basename( __FILE__ ) ) ) );

	wp_register_style( 'matty-theme-quickswitch', $plugin_url . 'assets/css/style.css', 'screen', '1.1.0' );
	wp_enqueue_style( 'matty-theme-quickswitch' );
} // End matty_theme_quickswitch_css()

/**
 * matty_theme_quickswitch_js function.
 * 
 * @access public
 * @return void
 */
function matty_theme_quickswitch_js () {
	if ( ! current_user_can( 'switch_themes' ) ) { return; }

	$plugin_url = trailingslashit( plugins_url( dirname( plugin_basename( __FILE__ ) ) ) );

	wp_register_script( 'matty-theme-quickswitch', $plugin_url . 'assets/js/functions.js', array( 'jquery' ), time() );
	wp_enqueue_script( 'matty-theme-quickswitch' );
} // End matty_theme_quickswitch_js()
?>