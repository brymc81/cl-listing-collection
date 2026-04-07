<?php
/**
 * Plugin Name: CL Listing Collection
 * Description: Bricks element that renders a listing carousel from the canonical cl-reso-link API.
 * Version: 0.4.0
 * Author: Charleston Livability
 */

if ( ! defined( "ABSPATH" ) ) {
    exit;
}

define( "CLLC_PLUGIN_FILE", __FILE__ );
define( "CLLC_PLUGIN_DIR", plugin_dir_path( __FILE__ ) );
define( "CLLC_VERSION", "0.4.0" );

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

    $listing_card_file = CLLC_PLUGIN_DIR . "listing-card/listing-card.php";
    if ( ! file_exists( $listing_card_file ) ) {
        cllc_log_bricks( "Listing card file missing: " . $listing_card_file );
        return;
    }
    require_once $listing_card_file;

    $listing_grid_file = CLLC_PLUGIN_DIR . "listing-grid/listing-grid.php";
    if ( ! file_exists( $listing_grid_file ) ) {
        cllc_log_bricks( "Listing grid file missing: " . $listing_grid_file );
        return;
    }
    require_once $listing_grid_file;

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
        CLLC_PLUGIN_DIR . "listing-card/listing-card.php",
        CLLC_PLUGIN_DIR . "listing-grid/listing-grid.php",
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
 * Normalize context identity and slug values.
 */
function cllc_normalize_context_identity( $value ): string {
    if ( ! is_string( $value ) ) {
        return "";
    }

    $normalized = trim( sanitize_text_field( $value ) );
    return "" !== $normalized ? $normalized : "";
}

/**
 * Resolve cl-reso-link community context endpoint.
 */
function cllc_get_community_context_endpoint(): string {
    $endpoint = rest_url( "cl-reso-link/v1/community" );
    return (string) apply_filters( "cl_listing_collection_context_endpoint", $endpoint );
}

/**
 * Resolve community context by community_key and return canonical slug.
 *
 * @return array<string, string>|null
 */
function cllc_resolve_community_context( $community_key ) {
    $community_key_raw = is_string( $community_key ) ? cllc_normalize_context_identity( $community_key ) : "";
    if ( "" === $community_key_raw ) {
        return null;
    }

    $endpoint = cllc_get_community_context_endpoint();
    if ( "" === $endpoint ) {
        return null;
    }

    $url = add_query_arg(
        [
            "community_key" => $community_key_raw,
        ],
        $endpoint
    );

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
        return null;
    }

    if ( 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
        return null;
    }

    $decoded = json_decode( (string) wp_remote_retrieve_body( $response ), true );
    if ( ! is_array( $decoded ) || ! isset( $decoded["community"] ) || ! is_array( $decoded["community"] ) ) {
        return null;
    }

    $slug = $decoded["community"]["slug"] ?? "";
    if ( ! is_string( $slug ) ) {
        return null;
    }
    $slug = cllc_normalize_context_identity( $slug );
    if ( "" === $slug ) {
        return null;
    }

    return [
        "community_key" => $community_key_raw,
        "slug" => $slug,
    ];
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
 * Fetch listings via the canonical cl-reso-link endpoint.
 *
 * @return array{ok:bool,code:int,items:array,error:bool,decoded:bool,state:string}
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
            "state" => "",
        ];
        return $cache[ $cache_key ];
    }

    $code = (int) wp_remote_retrieve_response_code( $response );
    $body = (string) wp_remote_retrieve_body( $response );
    $decoded = json_decode( $body, true );
    $decoded_ok = json_last_error() === JSON_ERROR_NONE;
    $items = [];
    $state = "";
    $shape_valid = false;
    if ( $decoded_ok && is_array( $decoded ) ) {
        if ( isset( $decoded["data"]["items"] ) && is_array( $decoded["data"]["items"] ) ) {
            $items = $decoded["data"]["items"];
            $shape_valid = true;
        } elseif ( cllc_is_soft_failure_payload( $decoded ) ) {
            $items = $decoded["items"];
            $state = strtolower( trim( (string) $decoded["state"] ) );
            $shape_valid = true;
        } else {
            cllc_log_unexpected_response_shape( $decoded );
        }
    }

    $ok = $code >= 200 && $code < 300;
    $error = ! $ok || ! $decoded_ok || ! $shape_valid;

    $cache[ $cache_key ] = [
        "ok" => $ok,
        "code" => $code,
        "items" => $items,
        "error" => $error,
        "decoded" => $decoded_ok,
        "state" => $state,
    ];

    return $cache[ $cache_key ];
}

/**
 * @param array<string, mixed> $payload
 */
function cllc_is_soft_failure_payload( array $payload ): bool {
    if ( ! isset( $payload["state"] ) || ! is_string( $payload["state"] ) ) {
        return false;
    }
    if ( ! isset( $payload["items"] ) || ! is_array( $payload["items"] ) ) {
        return false;
    }

    $state = strtolower( trim( $payload["state"] ) );
    return in_array( $state, [ "no_context", "invalid_context", "engine_error" ], true );
}

/**
 * @param array<string, mixed> $payload
 */
function cllc_log_unexpected_response_shape( array $payload ): void {
    $root_keys = implode( ",", array_keys( $payload ) );
    $data_keys = "";
    if ( isset( $payload["data"] ) && is_array( $payload["data"] ) ) {
        $data_keys = implode( ",", array_keys( $payload["data"] ) );
    }

    error_log( "[CL Listing Collection] Unexpected listings response shape: root_keys=" . $root_keys . "; data_keys=" . $data_keys ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
}
