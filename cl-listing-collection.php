<?php
/**
 * Plugin Name: CL Listing Collection
 * Description: Bricks element that renders a listing carousel from the canonical cl-reso-link API.
 * Version: 0.3.0
 * Author: Charleston Livability
 */

if ( ! defined( "ABSPATH" ) ) {
    exit;
}

define( "CLLC_PLUGIN_FILE", __FILE__ );
define( "CLLC_PLUGIN_DIR", plugin_dir_path( __FILE__ ) );
define( "CLLC_VERSION", "0.3.0" );

add_action( "init", "cllc_register_bricks_elements", 11 );
add_action( "init", "cllc_maybe_clear_bricks_cache", 12 );
add_filter( "bricks/elements/categories", "cllc_register_bricks_category" );

/**
 * Register Bricks element (optional dependency).
 */
function cllc_register_bricks_elements(): void {
    if ( ! class_exists( "\\Bricks\\Elements" ) ) {
        cllc_log_bricks( "Bricks\\Elements missing - registration skipped" );
        return;
    }

    $element_file = CLLC_PLUGIN_DIR . "includes/bricks/class-listing-carousel-element.php";
    if ( ! file_exists( $element_file ) ) {
        cllc_log_bricks( "Element file missing: " . $element_file );
        return;
    }

    require_once $element_file;

    if ( ! class_exists( "\\CL_Listing_Collection\\Bricks\\Listing_Carousel_Element" ) ) {
        cllc_log_bricks( "Element class not found after require" );
        return;
    }

    \Bricks\Elements::register_element( $element_file );
    cllc_log_bricks( "Element registered with Bricks" );
}

/**
 * Register Charleston Livability category for Bricks elements.
 *
 * @param array $categories
 * @return array
 */
function cllc_register_bricks_category( array $categories ): array {
    $categories[] = [
        "slug" => "charleston-livability",
        "name" => __( "Charleston Livability", "cl-listing-collection" ),
    ];

    return $categories;
}

/**
 * Clear Bricks cache when element source changes.
 */
function cllc_maybe_clear_bricks_cache(): void {
    if ( ! function_exists( "bricks_clear_cache" ) ) {
        return;
    }

    $element_files = [
        CLLC_PLUGIN_FILE,
        CLLC_PLUGIN_DIR . "includes/bricks/class-listing-carousel-element.php",
    ];

    $signature_parts = [];
    foreach ( $element_files as $element_file ) {
        $signature_parts[] = $element_file;
        $signature_parts[] = file_exists( $element_file ) ? (string) filemtime( $element_file ) : "0";
    }

    $signature = implode( "|", $signature_parts );
    $stored = get_option( "cllc_bricks_cache_signature", "" );
    if ( $signature === $stored ) {
        return;
    }

    bricks_clear_cache();
    update_option( "cllc_bricks_cache_signature", $signature );
    cllc_log_bricks( "Bricks cache cleared (signature changed)" );
}

/**
 * Bricks-only logging (no secrets).
 */
function cllc_log_bricks( string $message ): void {
    if ( defined( "WP_DEBUG" ) && WP_DEBUG ) {
        error_log( "CL Listing Collection (Bricks): " . $message ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
    }
}

/**
 * Check for blank values (treat 0 as non-blank).
 */
function cllc_is_blank( $value ): bool {
    if ( null === $value ) {
        return true;
    }
    if ( is_string( $value ) ) {
        return trim( $value ) == "";
    }
    if ( is_array( $value ) ) {
        return $value === [];
    }
    return false;
}

/**
 * Sanitize an integer input.
 */
function cllc_sanitize_int( $value ): ?int {
    if ( cllc_is_blank( $value ) ) {
        return null;
    }

    return absint( $value );
}

/**
 * Sanitize a float input.
 */
function cllc_sanitize_float( $value ): ?float {
    if ( cllc_is_blank( $value ) ) {
        return null;
    }
    if ( ! is_numeric( $value ) ) {
        return null;
    }

    return (float) $value;
}

/**
 * Sanitize a CSS size token or fall back to default.
 */
function cllc_sanitize_css_size( $value, string $default ): string {
    if ( cllc_is_blank( $value ) ) {
        return $default;
    }

    if ( is_numeric( $value ) ) {
        return (string) $value . "px";
    }

    $value = trim( (string) $value );
    if ( preg_match( '/^\d+(?:\.\d+)?(px|rem|em|vw|vh|%)$/', $value ) ) {
        return $value;
    }

    return $default;
}

/**
 * Format price values for display.
 */
function cllc_format_price( $value ): string {
    if ( cllc_is_blank( $value ) ) {
        return "";
    }
    if ( ! is_numeric( $value ) ) {
        return (string) $value;
    }

    return "$" . number_format( (float) $value, 0 );
}

/**
 * Determine if a listing status indicates a closed/sold state.
 */
function cllc_is_closed_status( $status ): bool {
    if ( cllc_is_blank( $status ) ) {
        return false;
    }

    $status = strtolower( trim( (string) $status ) );
    return strpos( $status, "closed" ) !== false || strpos( $status, "sold" ) !== false;
}

/**
 * Fetch listings via the canonical cl-reso-link endpoint.
 *
 * @return array{ok:bool,code:int,items:array,error:bool,decoded:bool}
 */
function cllc_fetch_listings( array $params ): array {
    static $cache = [];

    ksort( $params );
    $cache_key = md5( wp_json_encode( $params ) );
    if ( isset( $cache[ $cache_key ] ) ) {
        return $cache[ $cache_key ];
    }

    $url = add_query_arg( $params, home_url( "/api/properties/search" ) );
    $response = wp_remote_get(
        $url,
        [
            "timeout" => 8,
            "headers" => [
                "Accept" => "application/json",
            ],
        ]
    );

    if ( is_wp_error( $response ) ) {
        $cache[ $cache_key ] = [
            "ok" => false,
            "code" => 0,
            "items" => [],
            "error" => true,
            "decoded" => false,
        ];
        return $cache[ $cache_key ];
    }

    $code = (int) wp_remote_retrieve_response_code( $response );
    $body = (string) wp_remote_retrieve_body( $response );
    $decoded = json_decode( $body, true );
    $decoded_ok = json_last_error() === JSON_ERROR_NONE;
    $items = [];
    if ( $decoded_ok && is_array( $decoded ) && isset( $decoded["data"]["items"] ) && is_array( $decoded["data"]["items"] ) ) {
        $items = $decoded["data"]["items"];
    }

    $cache[ $cache_key ] = [
        "ok" => $code >= 200 && $code < 300,
        "code" => $code,
        "items" => $items,
        "error" => false,
        "decoded" => $decoded_ok,
    ];

    return $cache[ $cache_key ];
}
