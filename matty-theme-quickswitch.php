<?php
/*
Plugin Name: Matty Theme QuickSwitch
Plugin URI: http://matty.co.za/
Description: Adds a quick theme switcher to the WordPress Admin Bar, aimed at speeding up rapid theme switching during theme development and maintenance.
Author: Matty
Author URI: http://matty.co.za/
Version: 1.2.3
Stable tag: 1.2.3
License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

if ( is_admin() ) {
	add_action( 'admin_bar_menu', 'matty_theme_quickswitch_menu', 1 );
	add_action( 'admin_print_styles', 'matty_theme_quickswitch_css', 10 );
	add_action( 'admin_enqueue_scripts', 'matty_theme_quickswitch_js', 10 );
}

/**
 * Add the theme switcher menu to the WordPress Toolbar.
 * 
 * @access public
 * @since 1.0.0
 * @return void
 */
function matty_theme_quickswitch_menu () {
	global $wp_admin_bar, $current_user;

	if ( ! current_user_can( 'switch_themes' ) ) { return; }
	
	$child_themes = array();
	$parent_themes = array();

	if ( function_exists( 'wp_get_themes' ) ) {
		$themes = wp_get_themes();
	} else {
		$themes = get_themes();
	}

	if ( ! isset( $themes  ) || ! is_array( $themes ) ) { return; }

	if ( function_exists( 'wp_get_theme' ) ) {
		$current_theme = wp_get_theme();
		$menu_label = $current_theme->display( 'Name' );
	} else {
		$current_theme = get_theme_data( get_stylesheet_directory() . '/style.css' );
		$menu_label = $current_theme['Name'];
	}

	$count = 0;
	$has_child_themes = false;
	$end_child_themes = false;
	
	$menu_id = 'matty-theme-quickswitch';

	foreach ( $themes as $k => $v ) {
		if ( $v['Template'] != $v['Stylesheet'] ) {
			$child_themes[] = $v;
		} else {
			$parent_themes[] = $v;
		}
	}

	// Main Menu Item
	$wp_admin_bar->add_menu( array( 'parent' => 'top-secondary', 'id' => $menu_id, 'title' => $menu_label, 'href' => '#' ) );

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

		if ( function_exists( 'wp_get_theme' ) ) {
			$template = $v->get_template();
			$stylesheet = $v->get_stylesheet();
		} else {
			$template = $v['Template'];
			$stylesheet = $v['Stylesheet'];
		}

		$id = urlencode( str_replace( '/', '-', strtolower( $stylesheet ) ) );
		$activate_link = wp_nonce_url( "themes.php?action=activate&amp;template=" . urlencode( $template ) . "&amp;stylesheet=" . urlencode( $stylesheet ), 'switch-theme_' . $stylesheet );
	
		if ( $has_child_themes == true && $end_child_themes == false && $template == $stylesheet ) {
			$wp_admin_bar->add_menu( array( 'parent' => 'matty-theme-quickswitch', 'id' => 'heading-parent-themes', 'title' => __( 'Parent Themes', 'matty-theme-quickswitch' ), 'href' => '#' ) );

			$end_child_themes = true;
		}

		$name = $v['Name'];
		if ( $name == $menu_label ) { $name = '<strong>' . $name . '</strong>'; }

		$wp_admin_bar->add_menu( array( 'parent' => 'matty-theme-quickswitch', 'id' => 'theme-' . $id, 'title' => $name, 'href' => $activate_link ) );
	}
} // End matty_theme_quickswitch_menu()

/**
 * Load CSS for the plugin.
 * 
 * @access public
 * @since 1.0.0
 * @return void
 */
function matty_theme_quickswitch_css () {
	if ( ! current_user_can( 'switch_themes' ) ) { return; }

	$plugin_url = trailingslashit( plugin_dir_url( __FILE__ ) );

	wp_register_style( 'matty-theme-quickswitch', $plugin_url . 'assets/css/style.css', 'screen', '1.2.3' );
	wp_enqueue_style( 'matty-theme-quickswitch' );
} // End matty_theme_quickswitch_css()

/**
 * Load JavaScript for the plugin.
 * 
 * @access public
 * @since 1.1.0
 * @return void
 */
function matty_theme_quickswitch_js () {
	if ( ! current_user_can( 'switch_themes' ) ) { return; }

	$plugin_url = trailingslashit( plugin_dir_url( __FILE__ ) );

	wp_register_script( 'matty-theme-quickswitch', $plugin_url . 'assets/js/functions.js', array( 'jquery' ), '1.2.3' );
	wp_enqueue_script( 'matty-theme-quickswitch' );
} // End matty_theme_quickswitch_js()
?>