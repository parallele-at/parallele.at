<?php
/**
 * The Template for displaying all single posts
 *
 * @package  Magic-Grundstein
 * @since   0.0.1
 */

$context = Timber::get_context();
$post = Timber::query_post();
$context['post'] = $post;

$user = wp_get_current_user();

if ( (isset($user->ID) && isset($post->user) && $user->ID == $post->user) || current_user_can( 'manage_options') ) {
  Timber::render( array( 'single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig' ), $context );
} else {
  wp_redirect( '/login' );
  exit;
}
