<?php

declare( strict_types=1 );

namespace Bricks {
    class Element {
        public $settings = [];
        public $controls = [];
        public $control_groups = [];
        public $dynamic_data = [];

        public function render_dynamic_data( $value, $post_id ) {
            if ( is_string( $value ) && array_key_exists( $value, $this->dynamic_data ) ) {
                return $this->dynamic_data[ $value ];
            }

            return $value;
        }
    }
}

namespace {
    if ( ! defined( "ABSPATH" ) ) {
        define( "ABSPATH", __DIR__ );
    }

    define( "CLLC_PLUGIN_DIR", dirname( __DIR__, 2 ) . "/" );
    define( "CLLC_PLUGIN_FILE", dirname( __DIR__, 2 ) . "/cl-listing-collection.php" );
    define( "CLLC_VERSION", "test" );

    function __( $text, $domain = null ): string {
        return (string) $text;
    }

    function esc_html__( $text, $domain = null ): string {
        return htmlspecialchars( (string) $text, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8" );
    }

    function sanitize_text_field( $value ): string {
        return trim( strip_tags( (string) $value ) );
    }

    function get_the_ID(): int {
        return 1;
    }

    function plugins_url( $path, $file = null ): string {
        return "https://example.test/" . ltrim( (string) $path, "/" );
    }

    function wp_enqueue_style( $handle, $src = "", $deps = [], $ver = false ): void {
    }

    function wp_style_is( $handle, $status = "enqueued" ): bool {
        return false;
    }

    function apply_filters( $hook_name, $value ) {
        return $value;
    }

    function cllc_is_blank( $value ): bool {
        return null === $value || ( is_string( $value ) && trim( $value ) === "" );
    }

    function cllc_sanitize_int( $value ): ?int {
        return is_numeric( $value ) ? (int) $value : null;
    }

    function cllc_sanitize_float( $value ): ?float {
        return is_numeric( $value ) ? (float) $value : null;
    }

    $cllc_test_filters = null;
    function cllc_fetch_listings( array $filters ): array {
        global $cllc_test_filters;
        $cllc_test_filters = $filters;
        return [ "items" => [], "error" => false ];
    }

    require_once __DIR__ . "/class-listing-carousel-element.php";

    use CL_Listing_Collection\Bricks\Listing_Carousel_Element;

    $tests_run = 0;
    $tests_failed = 0;

    function assert_true( bool $condition, string $message ): void {
        global $tests_run, $tests_failed;
        $tests_run++;

        if ( $condition ) {
            echo "[PASS] " . $message . PHP_EOL;
            return;
        }

        $tests_failed++;
        echo "[FAIL] " . $message . PHP_EOL;
    }

    function render_with_settings( Listing_Carousel_Element $element, array $settings ): array {
        global $cllc_test_filters;
        $cllc_test_filters = null;
        $element->settings = $settings;
        ob_start();
        $element->render();
        $html = (string) ob_get_clean();

        return [ $cllc_test_filters, $html ];
    }

    $element = new Listing_Carousel_Element();
    $element->set_controls();

    $property_type_control = $element->controls["property_type"] ?? [];
    $expected_property_types = [
        "Residential" => "Residential",
        "Rental" => "Rental",
        "Multi-Family" => "Multi-Family",
        "Vacant Land" => "Vacant Land",
    ];
    assert_true( ( $property_type_control["options"] ?? null ) === $expected_property_types, "Property Type: exact canonical option set" );
    assert_true( ( $property_type_control["default"] ?? null ) === "Residential", "Property Type: Residential is the default" );
    assert_true( ! array_key_exists( "multiple", $property_type_control ), "Property Type: single-select control" );
    assert_true( ! array_key_exists( "community" . "_key_input", $element->controls ), "Geography: legacy Community Key control removed" );

    $style_control = $element->controls["style"] ?? [];
    assert_true(
        ( $style_control["label"] ?? null ) === "Listing Style"
            && ( $style_control["type"] ?? null ) === "text"
            && ( $style_control["group"] ?? null ) === "query"
            && ( $style_control["placeholder"] ?? null ) === "Charleston Single"
            && true === ( $style_control["hasDynamicData"] ?? null )
            && ( $style_control["description"] ?? null ) === "Accepts exact canonical style values; separate multiple values with commas.",
        "Style: canonical dynamic text control is registered"
    );

    [ $filters ] = render_with_settings( $element, [ "geo_shape_id_input" => "downtown_charleston__ansonborough" ] );
    assert_true( is_array( $filters ) && ( $filters["property_type"] ?? null ) === "Residential", "Filters: missing setting forwards default Residential" );

    [ $filters ] = render_with_settings( $element, [
        "geo_shape_id_input" => "downtown_charleston__ansonborough",
        "property_type" => "",
    ] );
    assert_true( is_array( $filters ) && ( $filters["property_type"] ?? null ) === "Residential", "Filters: blank setting forwards default Residential" );

    foreach ( [ "Residential", "Rental", "Multi-Family", "Vacant Land" ] as $property_type ) {
        [ $filters ] = render_with_settings( $element, [
            "geo_shape_id_input" => "downtown_charleston__ansonborough",
            "property_type" => $property_type,
        ] );
        assert_true( is_array( $filters ) && ( $filters["property_type"] ?? null ) === $property_type, "Filters: canonical property type forwards unchanged: " . $property_type );
    }

    [ $filters ] = render_with_settings( $element, [
        "geo_shape_id_input" => "downtown_charleston__ansonborough",
        "property_type" => "Single Family" . " Detached",
    ] );
    assert_true( is_array( $filters ) && ( $filters["property_type"] ?? null ) === "Residential", "Filters: obsolete subtype-like property type falls back to Residential" );

    [ $filters ] = render_with_settings( $element, [
        "geo_shape_id_input" => "downtown_charleston__ansonborough",
        "property_type" => "Multi" . " Family",
    ] );
    assert_true( is_array( $filters ) && ( $filters["property_type"] ?? null ) === "Residential", "Filters: obsolete broad property type spelling falls back to Residential" );

    [ $filters ] = render_with_settings( $element, [
        "geo_shape_id_input" => "downtown_charleston__ansonborough",
        "property_type" => [ "Single Family" . " Detached", "Multi" . " Family" ],
    ] );
    assert_true( is_array( $filters ) && ( $filters["property_type"] ?? null ) === "Residential", "Filters: legacy array containing only obsolete values falls back to Residential" );

    [ $filters ] = render_with_settings( $element, [
        "geo_shape_id_input" => "downtown_charleston__ansonborough",
        "property_type" => [ "Rental", "Vacant Land" ],
    ] );
    assert_true( is_array( $filters ) && ( $filters["property_type"] ?? null ) === "Rental", "Filters: legacy array setting remains renderable and forwards one canonical value" );

    [ $filters ] = render_with_settings( $element, [
        "geo_shape_id_input" => "downtown_charleston__ansonborough",
        "style" => "",
    ] );
    assert_true( is_array( $filters ) && ! array_key_exists( "style", $filters ), "Style: blank value is omitted" );

    [ $filters ] = render_with_settings( $element, [
        "geo_shape_id_input" => "downtown_charleston__ansonborough",
        "style" => "Charleston Single",
    ] );
    assert_true(
        is_array( $filters )
            && ( $filters["style"] ?? null ) === "Charleston Single"
            && ! array_key_exists( "property_subtype", $filters ),
        "Style: exact value forwards without inferring Property Subtype"
    );

    [ $filters ] = render_with_settings( $element, [
        "geo_shape_id_input" => "downtown_charleston__ansonborough",
        "style" => " Charleston Single , Traditional ",
    ] );
    assert_true( is_array( $filters ) && ( $filters["style"] ?? null ) === "Charleston Single,Traditional", "Style: comma-separated values are sanitized and forwarded" );

    [ $filters ] = render_with_settings( $element, [
        "geo_shape_id_input" => "downtown_charleston__ansonborough",
        "style" => "Charleston Single, ,Traditional,Charleston Single, ",
    ] );
    assert_true( is_array( $filters ) && ( $filters["style"] ?? null ) === "Charleston Single,Traditional", "Style: duplicate and blank entries are removed" );

    $element->dynamic_data["{listing_style}"] = "Charleston Single, Traditional";
    [ $filters ] = render_with_settings( $element, [
        "geo_shape_id_input" => "downtown_charleston__ansonborough",
        "style" => "{listing_style}",
    ] );
    $element->dynamic_data = [];
    assert_true( is_array( $filters ) && ( $filters["style"] ?? null ) === "Charleston Single,Traditional", "Style: Bricks dynamic text resolves before sanitization and forwarding" );

    $existing_filter_settings = [
        "geo_shape_id_input" => "downtown_charleston__ansonborough",
        "limit" => 7,
        "sort" => "price",
        "order" => "asc",
        "property_type" => "Residential",
        "property_subtype" => [ "Single Family Detached" ],
        "status" => [ "Active", "Pending" ],
        "price_min" => 400000,
        "price_max" => 900000,
        "beds_min" => 3,
        "baths_min" => 2,
    ];
    [ $filters_without_style ] = render_with_settings( $element, $existing_filter_settings );
    [ $filters_with_style ] = render_with_settings( $element, $existing_filter_settings + [ "style" => "Charleston Single" ] );
    unset( $filters_with_style["style"] );
    assert_true( $filters_with_style === $filters_without_style, "Style: existing request filters remain unchanged" );

    [ $filters, $html ] = render_with_settings( $element, [
        "community" . "_key_input" => "mount_pleasant",
        "community" . "_key" => "mount_pleasant",
    ] );
    assert_true( null === $filters && str_contains( $html, "No listings available." ), "Geography: legacy saved keys do not replace required geo shape input" );

    [ $filters, $html ] = render_with_settings( $element, [] );
    assert_true( null === $filters && str_contains( $html, "No listings available." ), "Geography: missing geo shape input renders safe empty state" );

    $reflection = new \ReflectionClass( $element );
    $display_method = $reflection->getMethod( "resolve_display_preferences" );
    $display_method->setAccessible( true );
    $display_preferences = $display_method->invoke( $element, [
        "show_location" => "false",
        "show_facts" => "false",
        "show_status" => "false",
    ] );
    assert_true( false === $display_preferences["show_location"] && false === $display_preferences["show_facts"] && false === $display_preferences["show_status"], "Display: explicitly saved false values normalize to false" );

    $display_preferences = $display_method->invoke( $element, [] );
    assert_true( true === $display_preferences["show_location"] && true === $display_preferences["show_facts"] && true === $display_preferences["show_status"], "Display: missing control keys default to true" );

    echo PHP_EOL . "Tests run: " . $tests_run . PHP_EOL;
    echo "Failures: " . $tests_failed . PHP_EOL;

    exit( $tests_failed > 0 ? 1 : 0 );
}
