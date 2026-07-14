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
        return cllc_is_blank( $value ) ? null : abs( (int) $value );
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
    $element->set_control_groups();
    $element->set_controls();

    assert_true(
        ( $element->control_groups["property_filters"]["title"] ?? null ) === "Property Filters",
        "Controls: Property Filters group is registered"
    );

    foreach ( [ "price_min", "price_max", "beds_min", "baths_min" ] as $existing_property_filter_key ) {
        $control = $element->controls[ $existing_property_filter_key ] ?? [];
        assert_true(
            ( $control["group"] ?? null ) === "property_filters",
            "Controls: existing setting key moved to Property Filters group: " . $existing_property_filter_key
        );
    }

    $numeric_property_controls = [
        "sqft_min" => "Square Feet Min",
        "sqft_max" => "Square Feet Max",
        "year_min" => "Year Built Min",
        "year_max" => "Year Built Max",
        "acres_min" => "Acreage Min",
        "acres_max" => "Acreage Max",
    ];
    foreach ( $numeric_property_controls as $control_key => $control_label ) {
        $control = $element->controls[ $control_key ] ?? [];
        assert_true(
            ( $control["label"] ?? null ) === $control_label
                && ( $control["type"] ?? null ) === "number"
                && ( $control["group"] ?? null ) === "property_filters"
                && ( $control["min"] ?? null ) === 0,
            "Controls: canonical numeric property filter registered: " . $control_key
        );
    }

    $primary_bedroom_control = $element->controls["primary_bedroom_main_level"] ?? [];
    assert_true(
        ( $primary_bedroom_control["label"] ?? null ) === "Primary Bedroom on Main Level"
            && ( $primary_bedroom_control["type"] ?? null ) === "select"
            && ( $primary_bedroom_control["group"] ?? null ) === "property_filters"
            && ( $primary_bedroom_control["options"] ?? null ) === [ "" => "Any", "true" => "Yes" ]
            && ( $primary_bedroom_control["default"] ?? null ) === "",
        "Controls: Primary Bedroom exposes only Any and Yes"
    );

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

    $new_filter_keys = [
        "sqft_min",
        "sqft_max",
        "year_min",
        "year_max",
        "acres_min",
        "acres_max",
        "primary_bedroom_main_level",
    ];
    [ $filters ] = render_with_settings( $element, $existing_filter_settings + array_fill_keys( $new_filter_keys, "" ) );
    $blank_filters_omitted = is_array( $filters );
    foreach ( $new_filter_keys as $new_filter_key ) {
        $blank_filters_omitted = $blank_filters_omitted && ! array_key_exists( $new_filter_key, $filters );
    }
    assert_true( $blank_filters_omitted, "Property filters: blank new values are omitted" );

    $all_filter_settings = $existing_filter_settings + [
        "style" => "Charleston Single",
        "sqft_min" => 1200.5,
        "sqft_max" => 3200,
        "year_min" => 1990,
        "year_max" => 2020,
        "acres_min" => 0.25,
        "acres_max" => 2.5,
        "primary_bedroom_main_level" => "true",
    ];
    [ $filters ] = render_with_settings( $element, $all_filter_settings );
    assert_true(
        is_array( $filters )
            && ( $filters["geo_shape_id"] ?? null ) === "downtown_charleston__ansonborough"
            && ( $filters["limit"] ?? null ) === 7
            && ( $filters["sort"] ?? null ) === "price"
            && ( $filters["order"] ?? null ) === "asc"
            && ( $filters["property_type"] ?? null ) === "Residential"
            && ( $filters["property_subtype"] ?? null ) === "Single Family Detached"
            && ( $filters["status"] ?? null ) === "Active,Pending"
            && ( $filters["price_min"] ?? null ) === 400000.0
            && ( $filters["price_max"] ?? null ) === 900000.0
            && ( $filters["beds_min"] ?? null ) === 3
            && ( $filters["baths_min"] ?? null ) === 2
            && ( $filters["style"] ?? null ) === "Charleston Single"
            && ( $filters["sqft_min"] ?? null ) === 1200.5
            && ( $filters["sqft_max"] ?? null ) === 3200.0
            && ( $filters["year_min"] ?? null ) === 1990
            && ( $filters["year_max"] ?? null ) === 2020
            && ( $filters["acres_min"] ?? null ) === 0.25
            && ( $filters["acres_max"] ?? null ) === 2.5
            && ( $filters["primary_bedroom_main_level"] ?? null ) === "true",
        "Property filters: all new canonical values forward together"
    );
    $existing_filters_with_new_values = $filters;
    foreach ( $new_filter_keys as $new_filter_key ) {
        unset( $existing_filters_with_new_values[ $new_filter_key ] );
    }
    unset( $existing_filters_with_new_values["style"] );
    assert_true( $existing_filters_with_new_values === $filters_without_style, "Property filters: existing request filters remain unchanged" );

    [ $filters ] = render_with_settings( $element, [
        "geo_shape_id_input" => "downtown_charleston__ansonborough",
        "sqft_min" => 0,
        "sqft_max" => 0,
        "year_min" => 0,
        "year_max" => 0,
        "acres_min" => 0,
        "acres_max" => 0,
    ] );
    assert_true(
        is_array( $filters )
            && ( $filters["sqft_min"] ?? null ) === 0.0
            && ( $filters["sqft_max"] ?? null ) === 0.0
            && ( $filters["year_min"] ?? null ) === 0
            && ( $filters["year_max"] ?? null ) === 0
            && ( $filters["acres_min"] ?? null ) === 0.0
            && ( $filters["acres_max"] ?? null ) === 0.0,
        "Property filters: canonical zero values are preserved"
    );

    [ $filters ] = render_with_settings( $element, [
        "geo_shape_id_input" => "downtown_charleston__ansonborough",
        "sqft_min" => -1,
        "sqft_max" => "invalid",
        "year_min" => -1,
        "year_max" => 1999.5,
        "acres_min" => -1,
        "acres_max" => "invalid",
    ] );
    $invalid_numeric_filters_omitted = is_array( $filters );
    foreach ( [ "sqft_min", "sqft_max", "year_min", "year_max", "acres_min", "acres_max" ] as $invalid_numeric_filter_key ) {
        $invalid_numeric_filters_omitted = $invalid_numeric_filters_omitted && ! array_key_exists( $invalid_numeric_filter_key, $filters );
    }
    assert_true( $invalid_numeric_filters_omitted, "Property filters: negative, fractional-year, and nonnumeric values are omitted" );

    foreach (
        [
            [ "sqft_min", "sqft_max", 2000, 1000 ],
            [ "year_min", "year_max", 2020, 1990 ],
            [ "acres_min", "acres_max", 2.5, 0.5 ],
        ] as $reversed_range
    ) {
        [ $min_key, $max_key, $min_value, $max_value ] = $reversed_range;
        [ $filters ] = render_with_settings( $element, [
            "geo_shape_id_input" => "downtown_charleston__ansonborough",
            $min_key => $min_value,
            $max_key => $max_value,
        ] );
        assert_true(
            is_array( $filters ) && ! array_key_exists( $min_key, $filters ) && ! array_key_exists( $max_key, $filters ),
            "Property filters: reversed range omits both values: " . $min_key . "/" . $max_key
        );
    }

    foreach (
        [
            [ "sqft_min", "sqft_max", 1500 ],
            [ "year_min", "year_max", 2000 ],
            [ "acres_min", "acres_max", 1.5 ],
        ] as $equal_range
    ) {
        [ $min_key, $max_key, $value ] = $equal_range;
        [ $filters ] = render_with_settings( $element, [
            "geo_shape_id_input" => "downtown_charleston__ansonborough",
            $min_key => $value,
            $max_key => $value,
        ] );
        assert_true(
            is_array( $filters ) && isset( $filters[ $min_key ], $filters[ $max_key ] ) && $filters[ $min_key ] === $filters[ $max_key ],
            "Property filters: equal range values are preserved: " . $min_key . "/" . $max_key
        );
    }

    [ $filters ] = render_with_settings( $element, [
        "geo_shape_id_input" => "downtown_charleston__ansonborough",
        "primary_bedroom_main_level" => "true",
    ] );
    assert_true( is_array( $filters ) && ( $filters["primary_bedroom_main_level"] ?? null ) === "true", "Property filters: Primary Bedroom true forwards canonically" );

    foreach ( [ "", "false", false, true, "0", "yes", " true ", "invalid" ] as $no_op_primary_bedroom_value ) {
        [ $filters ] = render_with_settings( $element, [
            "geo_shape_id_input" => "downtown_charleston__ansonborough",
            "primary_bedroom_main_level" => $no_op_primary_bedroom_value,
        ] );
        assert_true(
            is_array( $filters ) && ! array_key_exists( "primary_bedroom_main_level", $filters ),
            "Property filters: non-true Primary Bedroom value is omitted"
        );
    }

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
