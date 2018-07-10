<?php
function avatami_enqueue_styles() {
  $parent_style = 'magic-grundstein'; 

  wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.less' );
  wp_enqueue_style( 'child-style',
    get_stylesheet_directory_uri() . '/style.less',
    array( $parent_style ),
    wp_get_theme()->get('Version')
  );
}

add_action( 'wp_enqueue_scripts', 'avatami_enqueue_styles', PHP_INT_MIN );

// remove emoji scripts
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// remove embed.js but not the rest api and the auto discovery functionality
// embedding this blog on other blogs ~should~ work
add_action( 'init', function() {
  // Remove the REST API endpoint.
  remove_action('rest_api_init', 'wp_oembed_register_route');

  // Turn off oEmbed auto discovery.
  // Don't filter oEmbed results.
  remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

  // Remove oEmbed discovery links.
  remove_action('wp_head', 'wp_oembed_add_discovery_links');

  // Remove oEmbed-specific JavaScript from the front-end and back-end.
  remove_action('wp_head', 'wp_oembed_add_host_js');
}, PHP_INT_MAX - 1 );
