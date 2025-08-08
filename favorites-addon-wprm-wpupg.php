<?php
/**
 * Plugin Name: Favorites Add-on for WPRM & WPUPG (Minimal)
 * Description: Limits WPUPG grids to the logged-in user’s Favorites when ?only_bookmarks=1 is set.
 * Version: 0.1.0
 * Author: MiraScully
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'wpupg_query_post_args', function( $args, $query_args = null, $grid = null ) {
    // Only act when toggle is on.
    $toggle = isset( $_GET['only_bookmarks'] ) ? wp_unslash( $_GET['only_bookmarks'] ) : '';
    if ( '1' !== $toggle ) {
        return $args;
    }

    // Needs login + Favorites plugin.
    if ( ! is_user_logged_in() || ! function_exists( 'get_user_favorites' ) ) {
        return $args;
    }

    // Use the grid's post_type if set, otherwise default to posts + WPRM recipes.
    $post_types = ! empty( $args['post_type'] ) ? (array) $args['post_type'] : array( 'post', 'wprm_recipe' );

    // Get favorites and restrict query.
    $favorites = get_user_favorites( get_current_user_id(), '', array( 'post_types' => $post_types ) );
    $args['post__in'] = ! empty( $favorites ) ? array_map( 'intval', (array) $favorites ) : array( 0 );

    // Reset to page 1 so users don't land on empty pages.
    $args['paged'] = 1;

    // To keep favorites order, you can uncomment:
    // $args['orderby'] = 'post__in';

    return $args;
}, 10, 3 );
