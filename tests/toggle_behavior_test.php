<?php
// Define required WordPress constants and stub functions.
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ );
}

// Storage for added filters.
$wp_filters = [];
function add_filter( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
    global $wp_filters;
    $wp_filters[ $tag ] = $function_to_add;
}

function is_user_logged_in() {
    return true;
}

function get_user_favorites( $user_id, $site_id = '', $args = [] ) {
    return [ 101, 202 ];
}

function get_current_user_id() {
    return 1;
}

function sanitize_text_field( $str ) {
    return preg_replace( '/[\x00-\x1F\x7F]/u', '', trim( strip_tags( $str ) ) );
}

function wp_unslash( $value ) {
    return $value;
}

require __DIR__ . '/../favorites-addon-wprm-wpupg.php';

$callback = $wp_filters['wpupg_query_post_args'];

function assert_equal( $expected, $actual, $message ) {
    if ( $expected !== $actual ) {
        echo "FAIL: $message\nExpected: ";
        var_export( $expected );
        echo "\nActual: ";
        var_export( $actual );
        echo "\n";
        exit( 1 );
    } else {
        echo "PASS: $message\n";
    }
}

// Valid toggle
$_GET['only_bookmarks'] = '1';
$result = $callback( [] );
assert_equal( [ 'post__in' => [ 101, 202 ], 'paged' => 1 ], $result, 'Valid toggle enables favorites filter' );

// Invalid toggle
$_GET['only_bookmarks'] = '0';
$result = $callback( [] );
assert_equal( [], $result, 'Invalid numeric value disables favorites filter' );

// Non-numeric value
$_GET['only_bookmarks'] = 'abc';
$result = $callback( [] );
assert_equal( [], $result, 'Non-numeric value disables favorites filter' );

// Missing toggle
unset( $_GET['only_bookmarks'] );
$result = $callback( [] );
assert_equal( [], $result, 'Missing parameter disables favorites filter' );

echo "All tests passed\n";
