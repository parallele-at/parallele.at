<?php
/**
 * Custom functionality of this theme.
 *
 * @package ThemeParallelePolis
 * @since 0.0.1
 */

/**
 * Enqueue css stylesheets
 */
function avatami_enqueue_styles() {
	$parent_style = 'magic-grundstein';

	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.less', [], wp_get_theme()->get( 'Version' ) );

	wp_enqueue_style(
		'child-style',
		get_stylesheet_directory_uri() . '/style.less',
		array( $parent_style ),
		wp_get_theme()->get( 'Version' )
	);
}

add_action( 'wp_enqueue_scripts', 'avatami_enqueue_styles', PHP_INT_MIN );

