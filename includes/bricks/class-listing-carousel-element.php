<?php

namespace CL_Listing_Collection\Bricks;

use Bricks\Element;

if ( ! defined( "ABSPATH" ) ) {
    exit;
}

class Listing_Carousel_Element extends Element {
    // Carousel is an implementation variant within cl-listing-collection, not a separate plugin

    public $name = "cl-listing-carousel";
    public $category = "charleston-livability";
    public $icon = "ti-layout-slider-alt";

    public function get_name() {
        return "cl-listing-carousel";
    }

    public function get_label() {
        return __( "CL Listing Carousel", "cl-listing-collection" );
    }

    public function get_icon() {
        return "ti-layout-slider-alt";
    }

    public function get_keywords() {
        return [ "listing", "carousel", "cl" ];
    }

    public function set_control_groups() {
        $this->control_groups["query"] = [
            "title" => __( "Query", "cl-listing-collection" ),
        ];
        $this->control_groups["property_filters"] = [
            "title" => __( "Property Filters", "cl-listing-collection" ),
        ];
        $this->control_groups["advanced"] = [
            "title" => __( "Advanced", "cl-listing-collection" ),
        ];
        $this->control_groups["display"] = [
            "title" => __( "Display", "cl-listing-collection" ),
        ];
        $this->control_groups["layout"] = [
            "title" => __( "Layout", "cl-listing-collection" ),
        ];
        $this->control_groups["style"] = [
            "title" => __( "Style", "cl-listing-collection" ),
        ];
    }

    public function set_controls() {
        $this->controls["geo_shape_id_input"] = [
            "tab" => "content",
            "group" => "query",
            "label" => __( "Geo Shape ID", "cl-listing-collection" ),
            "type" => "text",
            "placeholder" => "downtown_charleston__ansonborough",
            "hasDynamicData" => true,
        ];

        $this->controls["limit"] = [
            "group" => "query",
            "label" => __( "Limit", "cl-listing-collection" ),
            "type" => "number",
            "min" => 1,
            "max" => 50,
            "default" => 4,
        ];

        $this->controls["sort"] = [
            "group" => "query",
            "label" => __( "Sort", "cl-listing-collection" ),
            "type" => "select",
            "options" => [
                "modified" => __( "Modified", "cl-listing-collection" ),
                "price" => __( "Price", "cl-listing-collection" ),
                "dom" => __( "Days on Market", "cl-listing-collection" ),
            ],
            "default" => "modified",
        ];

        $this->controls["order"] = [
            "group" => "query",
            "label" => __( "Order", "cl-listing-collection" ),
            "type" => "select",
            "options" => [
                "desc" => __( "Desc", "cl-listing-collection" ),
                "asc" => __( "Asc", "cl-listing-collection" ),
            ],
            "default" => "desc",
        ];

        $this->controls["property_type"] = [
            "group" => "query",
            "label" => __( "Property Type", "cl-listing-collection" ),
            "type" => "select",
            "options" => $this->get_property_type_options(),
            "default" => "Residential",
        ];

        $this->controls["property_subtype"] = [
            "group" => "query",
            "label" => __( "Property Subtype", "cl-listing-collection" ),
            "type" => "select",
            "options" => $this->get_property_subtype_options(),
            "multiple" => true,
            "placeholder" => __( "Select property subtypes", "cl-listing-collection" ),
        ];

        $this->controls["style"] = [
            "group" => "query",
            "label" => __( "Listing Style", "cl-listing-collection" ),
            "type" => "text",
            "placeholder" => "Charleston Single",
            "hasDynamicData" => true,
            "description" => __( "Accepts exact canonical style values; separate multiple values with commas.", "cl-listing-collection" ),
        ];

        $this->controls["status"] = [
            "group" => "query",
            "label" => __( "Status", "cl-listing-collection" ),
            "type" => "select",
            "options" => $this->get_status_options(),
            "multiple" => true,
            "default" => [ "Active" ],
            "placeholder" => __( "Select statuses", "cl-listing-collection" ),
        ];

        $this->controls["price_min"] = [
            "group" => "property_filters",
            "label" => __( "Price Min", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["price_max"] = [
            "group" => "property_filters",
            "label" => __( "Price Max", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["beds_min"] = [
            "group" => "property_filters",
            "label" => __( "Beds Min", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["baths_min"] = [
            "group" => "property_filters",
            "label" => __( "Baths Min", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["sqft_min"] = [
            "group" => "property_filters",
            "label" => __( "Square Feet Min", "cl-listing-collection" ),
            "type" => "number",
            "min" => 0,
        ];

        $this->controls["sqft_max"] = [
            "group" => "property_filters",
            "label" => __( "Square Feet Max", "cl-listing-collection" ),
            "type" => "number",
            "min" => 0,
        ];

        $this->controls["year_min"] = [
            "group" => "property_filters",
            "label" => __( "Year Built Min", "cl-listing-collection" ),
            "type" => "number",
            "min" => 0,
        ];

        $this->controls["year_max"] = [
            "group" => "property_filters",
            "label" => __( "Year Built Max", "cl-listing-collection" ),
            "type" => "number",
            "min" => 0,
        ];

        $this->controls["acres_min"] = [
            "group" => "property_filters",
            "label" => __( "Acreage Min", "cl-listing-collection" ),
            "type" => "number",
            "min" => 0,
        ];

        $this->controls["acres_max"] = [
            "group" => "property_filters",
            "label" => __( "Acreage Max", "cl-listing-collection" ),
            "type" => "number",
            "min" => 0,
        ];

        $this->controls["primary_bedroom_main_level"] = [
            "group" => "property_filters",
            "label" => __( "Primary Bedroom on Main Level", "cl-listing-collection" ),
            "type" => "select",
            "options" => [
                "" => __( "Any", "cl-listing-collection" ),
                "true" => __( "Yes", "cl-listing-collection" ),
            ],
            "default" => "",
        ];

        $this->controls["structured_data_mode"] = [
            "group" => "advanced",
            "label" => __( "Structured Data", "cl-listing-collection" ),
            "type" => "select",
            "options" => [
                "off" => __( "Off", "cl-listing-collection" ),
                "itemlist" => __( "ItemList", "cl-listing-collection" ),
            ],
            "default" => "itemlist",
        ];

        $this->controls["show_location"] = [
            "group" => "display",
            "label" => __( "Show Location", "cl-listing-collection" ),
            "type" => "select",
            "inline" => true,
            "options" => [
                "true" => __( "On", "cl-listing-collection" ),
                "false" => __( "Off", "cl-listing-collection" ),
            ],
            "default" => "true",
        ];

        $this->controls["show_facts"] = [
            "group" => "display",
            "label" => __( "Show Facts", "cl-listing-collection" ),
            "type" => "select",
            "inline" => true,
            "options" => [
                "true" => __( "On", "cl-listing-collection" ),
                "false" => __( "Off", "cl-listing-collection" ),
            ],
            "default" => "true",
        ];

        $this->controls["show_status"] = [
            "group" => "display",
            "label" => __( "Show Status", "cl-listing-collection" ),
            "type" => "select",
            "inline" => true,
            "options" => [
                "true" => __( "On", "cl-listing-collection" ),
                "false" => __( "Off", "cl-listing-collection" ),
            ],
            "default" => "true",
        ];

        $this->controls["compliance_display"] = [
            "group" => "display",
            "label" => __( "Compliance Display", "cl-listing-collection" ),
            "type" => "select",
            "options" => [
                "compact" => __( "Compact", "cl-listing-collection" ),
                "full" => __( "Full", "cl-listing-collection" ),
            ],
            "default" => "compact",
        ];

        $this->controls["card_width"] = [
            "group" => "layout",
            "label" => __( "Card Width", "cl-listing-collection" ),
            "type" => "text",
            "default" => "clamp(240px, 72vw, 360px)",
            "placeholder" => "clamp(240px, 72vw, 360px)",
        ];

        $this->controls["gap"] = [
            "group" => "layout",
            "label" => __( "Gap", "cl-listing-collection" ),
            "type" => "text",
            "default" => "1rem",
            "placeholder" => "1rem",
        ];

        $this->controls["card_background"] = [
            "group" => "style",
            "label" => __( "Card Background", "cl-listing-collection" ),
            "type" => "background",
            "css" => [
                [
                    "property" => "background",
                    "selector" => ".clpc-card",
                ],
            ],
        ];

        $this->controls["card_border_radius"] = [
            "group" => "style",
            "label" => __( "Card Border Radius", "cl-listing-collection" ),
            "type" => "number",
            "units" => true,
            "css" => [
                [
                    "property" => "border-radius",
                    "selector" => ".clpc-card",
                ],
            ],
            "placeholder" => "10px",
        ];

        $this->controls["price_typography"] = [
            "group" => "style",
            "label" => __( "Price Typography", "cl-listing-collection" ),
            "type" => "typography",
            "css" => [
                [
                    "property" => "font",
                    "selector" => ".clpc-card-price",
                ],
            ],
        ];

        $this->controls["address_typography"] = [
            "group" => "style",
            "label" => __( "Address Typography", "cl-listing-collection" ),
            "type" => "typography",
            "css" => [
                [
                    "property" => "font",
                    "selector" => ".clpc-card-address",
                ],
            ],
        ];

        $this->controls["meta_typography"] = [
            "group" => "style",
            "label" => __( "Meta Typography", "cl-listing-collection" ),
            "type" => "typography",
            "css" => [
                [
                    "property" => "font",
                    "selector" => ".clpc-card-meta",
                ],
            ],
        ];

        $this->controls["image_aspect_ratio"] = [
            "group" => "style",
            "label" => __( "Image Aspect Ratio", "cl-listing-collection" ),
            "type" => "select",
            "options" => [
                "1:1" => __( "1:1", "cl-listing-collection" ),
                "4:3" => __( "4:3", "cl-listing-collection" ),
                "16:9" => __( "16:9", "cl-listing-collection" ),
            ],
            "default" => "4:3",
        ];

        $this->controls["clickable"] = [
            "group" => "style",
            "label" => __( "Clickable Cards", "cl-listing-collection" ),
            "type" => "checkbox",
            "default" => true,
        ];

        $this->controls["open_in_new_tab"] = [
            "group" => "style",
            "label" => __( "Open In New Tab", "cl-listing-collection" ),
            "type" => "checkbox",
            "default" => false,
            "required" => [ "clickable", "=", true ],
        ];
    }

    /**
     * Resolve geography-scoped listing query, call canonical search endpoint, and render SSR cards.
     */
    public function render() {
        $settings = is_array( $this->settings ) ? $this->settings : [];

        $geo_shape_id = $this->resolve_geo_shape_id_input( $settings );
        if ( "" === $geo_shape_id ) {
            $this->log_warning( "Missing required geographic input; rendering empty state." );
            $this->enqueue_assets();
            $this->render_empty_state();
            return;
        }

        $structured_data_mode = isset( $settings["structured_data_mode"] )
            ? sanitize_text_field( (string) $settings["structured_data_mode"] )
            : "itemlist";
        if ( ! in_array( $structured_data_mode, [ "off", "itemlist" ], true ) ) {
            $structured_data_mode = "itemlist";
        }

        $limit = \cllc_sanitize_int( $settings["limit"] ?? null );
        if ( null === $limit ) {
            $limit = 4;
        }
        if ( $limit < 1 ) {
            $limit = 1;
        } elseif ( $limit > 50 ) {
            $limit = 50;
        }

        $sort_value = isset( $settings["sort"] ) ? sanitize_text_field( (string) $settings["sort"] ) : "modified";
        $order_value = isset( $settings["order"] ) ? sanitize_text_field( (string) $settings["order"] ) : "desc";
        $normalized_sort = $this->normalize_sort_value( $sort_value, $order_value );

        $filters = [
            "limit" => $limit,
            "sort" => $normalized_sort["sort"],
            "order" => $normalized_sort["order"],
        ];
        $filters["geo_shape_id"] = $geo_shape_id;

        $property_type = $this->normalize_property_type_value( $settings["property_type"] ?? "Residential" );
        if ( "" !== $property_type ) {
            $filters["property_type"] = $property_type;
        }

        $property_sub_types = $this->normalize_multi_select_value( $settings["property_subtype"] ?? null );
        if ( [] !== $property_sub_types ) {
            $filters["property_subtype"] = implode( ",", $property_sub_types );
        }

        $resolved_style = $this->resolve_dynamic_text_setting( $settings, [ "style" ] );
        $styles = $this->normalize_multi_select_value( $resolved_style );
        if ( [] !== $styles ) {
            $filters["style"] = implode( ",", $styles );
        }

        $statuses = $this->normalize_multi_select_value( $settings["status"] ?? null );
        if ( [] !== $statuses ) {
            $filters["status"] = implode( ",", $statuses );
        }

        $price_min = \cllc_sanitize_float( $settings["price_min"] ?? null );
        $price_max = \cllc_sanitize_float( $settings["price_max"] ?? null );
        if ( null !== $price_min && null !== $price_max && $price_min > $price_max ) {
            $price_min = null;
            $price_max = null;
        }
        if ( null !== $price_min ) {
            $filters["price_min"] = $price_min;
        }
        if ( null !== $price_max ) {
            $filters["price_max"] = $price_max;
        }

        $beds_min = \cllc_sanitize_int( $settings["beds_min"] ?? null );
        if ( null !== $beds_min && $beds_min > 0 ) {
            $filters["beds_min"] = $beds_min;
        }

        $baths_min = \cllc_sanitize_int( $settings["baths_min"] ?? null );
        if ( null !== $baths_min && $baths_min > 0 ) {
            $filters["baths_min"] = $baths_min;
        }

        $this->add_nonnegative_numeric_range_filters( $filters, $settings, "sqft_min", "sqft_max", false );
        $this->add_nonnegative_numeric_range_filters( $filters, $settings, "year_min", "year_max", true );
        $this->add_nonnegative_numeric_range_filters( $filters, $settings, "acres_min", "acres_max", false );

        if ( ( $settings["primary_bedroom_main_level"] ?? null ) === "true" ) {
            $filters["primary_bedroom_main_level"] = "true";
        }

        $response = \cllc_fetch_listings( $filters );
        $items = isset( $response["items"] ) && is_array( $response["items"] ) ? $response["items"] : [];

        if ( ! empty( $response["error"] ) ) {
            $this->log_warning( "Listings request failed; rendering empty state." );
            $items = [];
        }

        if ( $limit > 0 && count( $items ) > $limit ) {
            $items = array_slice( $items, 0, $limit );
        }

        $this->enqueue_assets();

        if ( empty( $items ) ) {
            $this->render_empty_state();
            return;
        }

        if ( ! $this->can_render_with_shared_card_component() ) {
            $this->log_warning( "cl-property-components card renderer unavailable; rendering empty state." );
            $this->render_empty_state();
            return;
        }

        $aspect_ratio_class = $this->resolve_aspect_ratio_class( $settings );
        $is_clickable = $this->resolve_bricks_boolean_setting( $settings, "clickable", true );
        $open_in_new_tab = $this->resolve_bricks_boolean_setting( $settings, "open_in_new_tab", false );
        $link_target = ( $is_clickable && $open_in_new_tab ) ? "_blank" : "_self";
        $display_preferences = $this->resolve_display_preferences( $settings );
        $card_view_models = [];
        foreach ( $items as $item ) {
            if ( ! is_array( $item ) ) {
                continue;
            }

            $card_view_model = $this->build_card_view_model( $item, $aspect_ratio_class, $link_target, $display_preferences, $is_clickable );
            if ( is_array( $card_view_model ) ) {
                $card_view_models[] = $card_view_model;
            }
        }

        if ( empty( $card_view_models ) ) {
            $this->render_empty_state();
            return;
        }

        $wrapper_style = $this->build_wrapper_css_vars( $settings );
        echo '<div class="cl-listing-carousel"' . $wrapper_style . '><div class="cl-listing-grid">';
        foreach ( $card_view_models as $card_view_model ) {
            echo clpc_render_property_card( $card_view_model );
        }
        echo "</div></div>";

        if ( $structured_data_mode === "itemlist" && ! $this->is_listing_detail_context() ) {
            $schema = $this->build_itemlist_schema( $card_view_models, $settings );
            if ( is_array( $schema ) ) {
                echo "<script type=\"application/ld+json\">";
                echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
                echo "</script>";
            }
        }
    }

    private function can_render_with_shared_card_component(): bool {
        return function_exists( "clpc_render_property_card" )
            && function_exists( "clpc_normalize_card_view_model" );
    }

    private function render_empty_state(): void {
        echo '<div class="cl-listing-collection__empty">' . esc_html__( 'No listings available.', 'cl-listing-collection' ) . '</div>';
    }

    private function resolve_aspect_ratio_class( array $settings ): string {
        $value = isset( $settings["image_aspect_ratio"] ) ? sanitize_text_field( (string) $settings["image_aspect_ratio"] ) : "4:3";
        $map = [
            "1:1" => "cl-card--ratio-1-1",
            "4:3" => "cl-card--ratio-4-3",
            "16:9" => "cl-card--ratio-16-9",
        ];

        return $map[ $value ] ?? $map["4:3"];
    }

    private function build_wrapper_css_vars( array $settings ): string {
        $card_width = $this->sanitize_css_value( $settings["card_width"] ?? "clamp(240px, 72vw, 360px)" );
        if ( $card_width === "" ) {
            $card_width = "clamp(240px, 72vw, 360px)";
        }

        $gap = $this->sanitize_css_value( $settings["gap"] ?? "1rem" );
        if ( $gap === "" ) {
            $gap = "1rem";
        }

        $image_ratio = isset( $settings["image_aspect_ratio"] ) ? sanitize_text_field( (string) $settings["image_aspect_ratio"] ) : "4:3";
        $image_ratio_css = $this->normalize_image_aspect_ratio_css_value( $image_ratio );

        $vars = sprintf(
            "--cllc-card-width:%s;--cllc-gap:%s;--cllc-image-ratio:%s;",
            $card_width,
            $gap,
            $image_ratio_css
        );

        return ' style="' . esc_attr( $vars ) . '"';
    }

    /**
     * Sanitize user-provided CSS values for CSS custom properties.
     */
    private function sanitize_css_value( $value ): string {
        if ( ! is_scalar( $value ) ) {
            return "";
        }

        $raw = trim( sanitize_text_field( (string) $value ) );
        if ( $raw === "" ) {
            return "";
        }

        if ( strlen( $raw ) > 120 ) {
            return "";
        }

        if ( 1 !== preg_match( '/^[a-zA-Z0-9\-\+\*\/\.\,\(\)%\s]+$/', $raw ) ) {
            return "";
        }

        return preg_replace( '/\s+/', ' ', $raw ) ?? "";
    }

    private function normalize_image_aspect_ratio_css_value( string $value ): string {
        $normalized = trim( strtolower( $value ) );
        $map = [
            "1:1" => "1 / 1",
            "4:3" => "4 / 3",
            "16:9" => "16 / 9",
        ];

        return $map[ $normalized ] ?? "4 / 3";
    }

    private function build_card_view_model( array $item, string $aspect_ratio_class, string $link_target, array $display_preferences, bool $is_clickable ): ?array {
        $detail_url = $this->resolve_card_detail_url( $item );
        if ( $detail_url === "" ) {
            return null;
        }

        $address = isset( $item["address"] ) && is_array( $item["address"] ) ? $item["address"] : [];
        $market = isset( $item["market"] ) && is_array( $item["market"] ) ? $item["market"] : [];
        $structure = isset( $item["structure"] ) && is_array( $item["structure"] ) ? $item["structure"] : [];
        $compliance = isset( $item["compliance"] ) && is_array( $item["compliance"] ) ? $item["compliance"] : [];

        $address_display = isset( $address["display"] ) && is_scalar( $address["display"] )
            ? trim( (string) $address["display"] )
            : "";
        $city = isset( $address["city"] ) && is_scalar( $address["city"] ) ? trim( (string) $address["city"] ) : "";
        $state = isset( $address["state"] ) && is_scalar( $address["state"] ) ? trim( (string) $address["state"] ) : "";
        $postal = isset( $address["postal_code"] ) && is_scalar( $address["postal_code"] ) ? trim( (string) $address["postal_code"] ) : "";
        if ( $city === "" && isset( $item["city"] ) && is_scalar( $item["city"] ) ) {
            $city = trim( (string) $item["city"] );
        }
        if ( $state === "" && isset( $item["state"] ) && is_scalar( $item["state"] ) ) {
            $state = trim( (string) $item["state"] );
        }
        if ( $postal === "" && isset( $item["postal_code"] ) && is_scalar( $item["postal_code"] ) ) {
            $postal = trim( (string) $item["postal_code"] );
        }
        $location_parts = array_values(
            array_filter(
                [ $city, $state, $postal ],
                static fn( string $part ): bool => $part !== ""
            )
        );
        $location = implode( ", ", $location_parts );

        $facts = [];
        $bedrooms_total = $this->format_numeric_value( $structure["bedrooms_total"] ?? null );
        if ( $bedrooms_total !== "" ) {
            $facts[] = $bedrooms_total . " bd";
        }

        $bathrooms_total = $this->format_numeric_value( $structure["bathrooms_total"] ?? null );
        if ( $bathrooms_total !== "" ) {
            $facts[] = $bathrooms_total . " ba";
        }

        $building_area_total = $this->format_integer_value( $structure["building_area_total"] ?? null );
        if ( $building_area_total !== "" ) {
            $facts[] = $building_area_total . " sqft";
        }

        $status = isset( $item["status"] ) && is_scalar( $item["status"] ) ? trim( (string) $item["status"] ) : "";
        $photo_url = $this->resolve_card_photo_url( $item );
        $compliance_view_model = $this->map_compact_compliance_for_card_view_model( $compliance );

        return [
            "card_class" => trim( "cl-card " . $aspect_ratio_class . ( $is_clickable ? " is-clickable" : "" ) ),
            "detail_url" => $detail_url,
            "photo_url" => $photo_url,
            "image_alt" => $address_display,
            "price" => $this->format_price( $market["list_price"] ?? null ),
            "address_display" => $address_display,
            "location" => $location,
            "facts" => implode( " | ", $facts ),
            "status" => $status,
            "link_target" => $link_target,
            "show_location" => $display_preferences["show_location"] ?? true,
            "show_facts" => $display_preferences["show_facts"] ?? true,
            "show_status" => $display_preferences["show_status"] ?? true,
            "compliance_display" => isset( $display_preferences["compliance_display"] ) ? (string) $display_preferences["compliance_display"] : "compact",
            // Preserve canonical compact compliance payload in the card view model.
            "compliance_compact" => $compliance,
            "compliance_source_mls_name" => $compliance_view_model["compliance_source_mls_name"],
            "compliance_listing_firm_name" => $compliance_view_model["compliance_listing_firm_name"],
            "compliance_listing_firm_mls_id" => $compliance_view_model["compliance_listing_firm_mls_id"],
            "compliance_selling_firm_name" => $compliance_view_model["compliance_selling_firm_name"],
            "compliance_idx_thumbnail_icon_url" => $compliance_view_model["compliance_idx_thumbnail_icon_url"],
            "compliance_idx_icon_url" => $compliance_view_model["compliance_idx_icon_url"],
            "compliance_idx_icon_alt" => $compliance_view_model["compliance_idx_icon_alt"],
            "compliance_copyright_text" => $compliance_view_model["compliance_copyright_text"],
            "compliance_is_other_participant_listing" => $compliance_view_model["compliance_is_other_participant_listing"],
        ];
    }

    private function map_compact_compliance_for_card_view_model( array $compliance ): array {
        return [
            "compliance_source_mls_name" => isset( $compliance["source_mls_name"] ) && is_scalar( $compliance["source_mls_name"] ) ? trim( (string) $compliance["source_mls_name"] ) : "",
            "compliance_listing_firm_name" => isset( $compliance["listing_firm_name"] ) && is_scalar( $compliance["listing_firm_name"] ) ? trim( (string) $compliance["listing_firm_name"] ) : "",
            "compliance_listing_firm_mls_id" => isset( $compliance["listing_firm_mls_id"] ) && is_scalar( $compliance["listing_firm_mls_id"] ) ? trim( (string) $compliance["listing_firm_mls_id"] ) : "",
            "compliance_selling_firm_name" => isset( $compliance["selling_firm_name"] ) && is_scalar( $compliance["selling_firm_name"] ) ? trim( (string) $compliance["selling_firm_name"] ) : "",
            "compliance_idx_thumbnail_icon_url" => isset( $compliance["idx_thumbnail_icon_url"] ) && is_scalar( $compliance["idx_thumbnail_icon_url"] ) ? trim( (string) $compliance["idx_thumbnail_icon_url"] ) : "",
            "compliance_idx_icon_url" => isset( $compliance["idx_icon_url"] ) && is_scalar( $compliance["idx_icon_url"] ) ? trim( (string) $compliance["idx_icon_url"] ) : "",
            "compliance_idx_icon_alt" => isset( $compliance["idx_icon_alt"] ) && is_scalar( $compliance["idx_icon_alt"] ) ? trim( (string) $compliance["idx_icon_alt"] ) : "",
            "compliance_copyright_text" => isset( $compliance["copyright_text"] ) && is_scalar( $compliance["copyright_text"] ) ? trim( (string) $compliance["copyright_text"] ) : "",
            "compliance_is_other_participant_listing" => ! empty( $compliance["is_other_participant_listing"] ),
        ];
    }

    private function resolve_display_preferences( array $settings ): array {
        $compliance_display = isset( $settings["compliance_display"] ) ? sanitize_text_field( (string) $settings["compliance_display"] ) : "compact";
        if ( ! in_array( $compliance_display, [ "compact", "full" ], true ) ) {
            $compliance_display = "compact";
        }

        return [
            "show_location" => $this->resolve_bricks_boolean_setting( $settings, "show_location", true ),
            "show_facts" => $this->resolve_bricks_boolean_setting( $settings, "show_facts", true ),
            "show_status" => $this->resolve_bricks_boolean_setting( $settings, "show_status", true ),
            "compliance_display" => $compliance_display,
        ];
    }

    private function resolve_bricks_boolean_setting( array $settings, string $key, bool $default ): bool {
        if ( ! array_key_exists( $key, $settings ) ) {
            return $default;
        }

        return $this->normalize_bricks_boolean_value( $settings[ $key ] );
    }

    /**
     * Strict boolean normalization for Bricks control values.
     */
    private function normalize_bricks_boolean_value( $value ): bool {
        if ( null === $value ) {
            return false;
        }

        if ( is_bool( $value ) ) {
            return $value;
        }

        if ( is_numeric( $value ) ) {
            $numeric = (string) (int) $value;
            return $numeric === "1";
        }

        if ( is_string( $value ) ) {
            $normalized = strtolower( trim( $value ) );
            if ( in_array( $normalized, [ "true", "1", "on", "yes" ], true ) ) {
                return true;
            }

            if ( in_array( $normalized, [ "false", "0", "off", "no", "" ], true ) ) {
                return false;
            }
        }

        // Strict mode: null and unknown values resolve to false.
        return false;
    }

    private function resolve_card_detail_url( array $item ): string {
        if ( ! isset( $item["detail_url"] ) || ! is_scalar( $item["detail_url"] ) ) {
            return "";
        }

        $detail_url = esc_url_raw( trim( (string) $item["detail_url"] ) );
        return is_string( $detail_url ) ? trim( $detail_url ) : "";
    }

    private function resolve_card_photo_url( array $item ): string {
        $media = isset( $item["media"] ) && is_array( $item["media"] ) ? $item["media"] : [];
        $candidate = "";

        if ( isset( $media["primary"] ) && is_string( $media["primary"] ) ) {
            $candidate = trim( $media["primary"] );
        } elseif ( isset( $media["primary"] ) && is_array( $media["primary"] ) && isset( $media["primary"]["url"] ) && is_scalar( $media["primary"]["url"] ) ) {
            $candidate = trim( (string) $media["primary"]["url"] );
        } elseif ( isset( $media["primary_photo"] ) && is_string( $media["primary_photo"] ) ) {
            $candidate = trim( $media["primary_photo"] );
        }

        if ( $candidate === "" ) {
            return "";
        }

        $sanitized = esc_url_raw( $candidate );
        return is_string( $sanitized ) ? trim( $sanitized ) : "";
    }

    private function format_price( $value ): string {
        if ( ! is_numeric( $value ) ) {
            return "";
        }

        return "$" . number_format( (float) $value, 0 );
    }

    private function format_numeric_value( $value ): string {
        if ( ! is_numeric( $value ) ) {
            return "";
        }

        $number = (float) $value;
        if ( floor( $number ) === $number ) {
            return (string) (int) $number;
        }

        return rtrim( rtrim( (string) $number, "0" ), "." );
    }

    private function format_integer_value( $value ): string {
        if ( ! is_numeric( $value ) ) {
            return "";
        }

        return number_format( (float) $value, 0 );
    }

    private function is_listing_detail_context(): bool {
        if ( function_exists( "get_query_var" ) ) {
            $listing_id = get_query_var( "listingId" );
            if ( is_numeric( $listing_id ) ) {
                return true;
            }
        }

        global $wp;
        if ( is_object( $wp ) && isset( $wp->matched_rule ) && is_string( $wp->matched_rule ) ) {
            if ( $wp->matched_rule === "^listing/([0-9]+)/?$" ) {
                return true;
            }
        }

        if ( function_exists( "cl_listing_router_is_seo_listing_context" ) ) {
            return (bool) cl_listing_router_is_seo_listing_context();
        }

        return false;
    }

    private function build_itemlist_schema( array $card_view_models, array $settings ): ?array {
        if ( empty( $card_view_models ) ) {
            return null;
        }

        $item_list_elements = [];
        $position = 1;

        foreach ( $card_view_models as $item ) {
            if ( ! is_array( $item ) ) {
                continue;
            }

            $item_url = $this->resolve_item_url( $item );
            if ( $item_url === "" ) {
                continue;
            }

            $item_name = $this->resolve_item_name( $item );
            $list_item = [
                "@type" => "ListItem",
                "position" => $position++,
                "url" => $item_url,
                "item" => [
                    "@type" => "RealEstateListing",
                    "@id" => $item_url,
                ],
            ];

            if ( $item_name !== "" ) {
                $list_item["name"] = $item_name;
            }

            $item_list_elements[] = $list_item;
        }

        if ( empty( $item_list_elements ) ) {
            return null;
        }

        $schema = [
            "@context" => "https://schema.org",
            "@type" => "ItemList",
            "itemListElement" => $item_list_elements,
        ];

        $schema_name = $this->resolve_schema_name( $settings );
        if ( $schema_name !== "" ) {
            $schema["name"] = $schema_name;
        }

        $schema = $this->strip_schema_empty_values( $schema );
        if ( ! is_array( $schema ) || empty( $schema ) ) {
            return null;
        }

        return $schema;
    }

    private function resolve_item_url( array $item ): string {
        $detail_url = isset( $item["detail_url"] ) && is_string( $item["detail_url"] )
            ? trim( $item["detail_url"] )
            : "";
        $detail_url = esc_url_raw( $detail_url );
        return is_string( $detail_url ) ? trim( $detail_url ) : "";
    }

    private function resolve_item_name( array $item ): string {
        $address = isset( $item["address_display"] ) ? (string) $item["address_display"] : "";
        return trim( $address );
    }

    private function resolve_schema_name( array $settings ): string {
        $name = $settings["title"] ?? "";
        if ( \cllc_is_blank( $name ) ) {
            $name = $settings["heading"] ?? "";
        }

        if ( \cllc_is_blank( $name ) ) {
            return "";
        }

        $clean = sanitize_text_field( (string) $name );
        return $clean !== "" ? $clean : "";
    }

    private function strip_schema_empty_values( $value ) {
        if ( is_array( $value ) ) {
            $is_list = $this->is_list_array( $value );
            $clean = [];

            foreach ( $value as $key => $entry ) {
                $stripped = $this->strip_schema_empty_values( $entry );
                if ( $this->schema_value_is_empty( $stripped ) ) {
                    continue;
                }

                if ( $is_list ) {
                    $clean[] = $stripped;
                } else {
                    $clean[ $key ] = $stripped;
                }
            }

            return empty( $clean ) ? null : $clean;
        }

        if ( is_string( $value ) ) {
            $trimmed = trim( $value );
            return $trimmed === "" ? null : $value;
        }

        return $value;
    }

    private function schema_value_is_empty( $value ): bool {
        if ( null === $value ) {
            return true;
        }

        if ( is_string( $value ) ) {
            return trim( $value ) === "";
        }

        if ( is_array( $value ) ) {
            return empty( $value );
        }

        return false;
    }

    private function is_list_array( array $value ): bool {
        $expected = 0;
        foreach ( array_keys( $value ) as $key ) {
            if ( $key !== $expected ) {
                return false;
            }
            $expected++;
        }

        return true;
    }

    private function enqueue_assets(): void {
        $style_file = CLLC_PLUGIN_DIR . "assets/css/listing-collection.css";
        $grid_style_file = CLLC_PLUGIN_DIR . "listing-grid/listing-grid.css";

        $style_url = plugins_url( "assets/css/listing-collection.css", CLLC_PLUGIN_FILE );
        $grid_style_url = plugins_url( "listing-grid/listing-grid.css", CLLC_PLUGIN_FILE );
        $style_version = file_exists( $style_file ) ? (string) filemtime( $style_file ) : CLLC_VERSION;
        $grid_style_version = file_exists( $grid_style_file ) ? (string) filemtime( $grid_style_file ) : CLLC_VERSION;

        wp_enqueue_style( "cllc-listing-collection", $style_url, [], $style_version );
        wp_enqueue_style( "cllc-listing-grid", $grid_style_url, [], $grid_style_version );

        if ( wp_style_is( "cl-property-components", "registered" ) ) {
            wp_enqueue_style( "cl-property-components" );
        }
    }

    private function get_property_type_options(): array {
        return [
            "Residential" => __( "Residential", "cl-listing-collection" ),
            "Rental" => __( "Rental", "cl-listing-collection" ),
            "Multi-Family" => __( "Multi-Family", "cl-listing-collection" ),
            "Vacant Land" => __( "Vacant Land", "cl-listing-collection" ),
        ];
    }

    private function get_property_subtype_options(): array {
        $defaults = [
            "Single Family Detached" => __( "Single Family Detached", "cl-listing-collection" ),
            "Single Family Attached" => __( "Single Family Attached", "cl-listing-collection" ),
        ];

        $options = apply_filters( "cllc_property_subtype_options", $defaults );
        if ( ! is_array( $options ) ) {
            return $defaults;
        }

        return $options;
    }

    private function get_status_options(): array {
        $defaults = [
            "Active" => __( "Active", "cl-listing-collection" ),
            "Active Under Contract" => __( "Active Under Contract", "cl-listing-collection" ),
            "Pending" => __( "Pending", "cl-listing-collection" ),
            "Closed" => __( "Closed", "cl-listing-collection" ),
        ];

        $options = apply_filters( "cllc_status_options", $defaults );
        if ( ! is_array( $options ) ) {
            return $defaults;
        }

        return $options;
    }

    /**
     * @param mixed $value
     * @return array<int, string>
     */
    private function normalize_multi_select_value( $value ): array {
        if ( \cllc_is_blank( $value ) ) {
            return [];
        }

        $parts = [];
        if ( is_array( $value ) ) {
            $parts = $value;
        } elseif ( is_string( $value ) ) {
            $parts = strpos( $value, "," ) !== false ? explode( ",", $value ) : [ $value ];
        }

        if ( [] === $parts ) {
            return [];
        }

        $resolved = [];
        foreach ( $parts as $part ) {
            if ( ! is_scalar( $part ) ) {
                continue;
            }

            $clean = trim( sanitize_text_field( (string) $part ) );
            if ( "" !== $clean ) {
                $resolved[] = $clean;
            }
        }

        if ( [] === $resolved ) {
            return [];
        }

        return array_values( array_unique( $resolved ) );
    }

    private function add_nonnegative_numeric_range_filters( array &$filters, array $settings, string $min_key, string $max_key, bool $integer ): void {
        $sanitize = static function ( $value ) use ( $integer ) {
            if ( ! is_numeric( $value ) ) {
                return null;
            }

            $numeric_value = (float) $value;
            if ( $numeric_value < 0 || ( $integer && floor( $numeric_value ) !== $numeric_value ) ) {
                return null;
            }

            return $integer ? \cllc_sanitize_int( $value ) : \cllc_sanitize_float( $value );
        };

        $min_value = $sanitize( $settings[ $min_key ] ?? null );
        $max_value = $sanitize( $settings[ $max_key ] ?? null );
        if ( null !== $min_value && null !== $max_value && $min_value > $max_value ) {
            return;
        }

        if ( null !== $min_value ) {
            $filters[ $min_key ] = $min_value;
        }
        if ( null !== $max_value ) {
            $filters[ $max_key ] = $max_value;
        }
    }

    /**
     * Resolve a single canonical broad property type from current or legacy saved settings.
     *
     * Legacy multi-select arrays are tolerated so old Bricks elements remain renderable, but
     * only an already-canonical broad value is forwarded. Unusable values use the documented
     * Residential default rather than leaving the request unscoped.
     *
     * @param mixed $value
     */
    private function normalize_property_type_value( $value ): string {
        $canonical_values = [ "Residential", "Rental", "Multi-Family", "Vacant Land" ];
        $candidates = $this->normalize_multi_select_value( $value );

        foreach ( $candidates as $candidate ) {
            if ( in_array( $candidate, $canonical_values, true ) ) {
                return $candidate;
            }
        }

        return "Residential";
    }

    private function normalize_sort_value( string $sort_value, string $order_value ): array {
        $defaults = [
            "modified" => "desc",
            "price" => "asc",
            "dom" => "desc",
        ];

        $sort = strtolower( trim( $sort_value ) );
        if ( ! isset( $defaults[ $sort ] ) ) {
            $sort = "modified";
        }

        $order = strtolower( trim( $order_value ) );
        if ( "asc" !== $order && "desc" !== $order ) {
            $order = $defaults[ $sort ];
        }

        return [
            "sort" => $sort,
            "order" => $order,
        ];
    }

    private function is_unresolved_dynamic_placeholder( string $value ): bool {
        return 1 === preg_match( '/^\{[a-z0-9_:-]+\}$/i', trim( $value ) );
    }

    private function resolve_geo_shape_id_input( array $settings ): string {
        $resolved_value = $this->resolve_dynamic_text_setting(
            $settings,
            [
                "geo_shape_id_input",
            ]
        );

        if ( "" === $resolved_value ) {
            return "";
        }

        return $this->sanitize_geo_shape_id( $resolved_value );
    }

    private function resolve_dynamic_text_setting( array $settings, array $setting_keys ): string {
        foreach ( $setting_keys as $setting_key ) {
            if ( ! is_string( $setting_key ) || ! array_key_exists( $setting_key, $settings ) ) {
                continue;
            }

            $raw = $settings[ $setting_key ];
            $resolved = $this->render_dynamic_data( $raw, get_the_ID() );
            if ( ! is_scalar( $resolved ) ) {
                continue;
            }

            $resolved_string = trim( (string) $resolved );
            if ( $this->is_unresolved_dynamic_placeholder( $resolved_string ) ) {
                continue;
            }

            if ( "" !== $resolved_string ) {
                return $resolved_string;
            }
        }

        return "";
    }

    private function sanitize_geo_shape_id( string $value ): string {
        $normalized = strtolower( trim( sanitize_text_field( $value ) ) );
        if ( "" === $normalized ) {
            return "";
        }

        if ( 1 !== preg_match( '/^[a-z0-9_-]{1,64}$/', $normalized ) ) {
            $this->log_warning( "Invalid geo_shape_id_input format; rendering empty state." );
            return "";
        }

        return $normalized;
    }

    private function log_warning( string $message ): void {
        error_log( "[CL Listing Collection] " . $message ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
    }
}
