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
        $this->control_groups["advanced"] = [
            "title" => __( "Advanced", "cl-listing-collection" ),
        ];
        $this->control_groups["style"] = [
            "title" => __( "Style", "cl-listing-collection" ),
        ];
    }

    public function set_controls() {
        $this->controls["community_key_input"] = [
            "tab" => "content",
            "group" => "query",
            "label" => __( "Community Key", "cl-listing-collection" ),
            "type" => "text",
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
            "multiple" => true,
            "default" => [],
            "placeholder" => __( "Select property type", "cl-listing-collection" ),
        ];

        $this->controls["property_subtype"] = [
            "group" => "query",
            "label" => __( "Property Subtype", "cl-listing-collection" ),
            "type" => "select",
            "options" => $this->get_property_subtype_options(),
            "multiple" => true,
            "placeholder" => __( "Select property subtypes", "cl-listing-collection" ),
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
            "group" => "query",
            "label" => __( "Price Min", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["price_max"] = [
            "group" => "query",
            "label" => __( "Price Max", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["beds_min"] = [
            "group" => "query",
            "label" => __( "Beds Min", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["baths_min"] = [
            "group" => "query",
            "label" => __( "Baths Min", "cl-listing-collection" ),
            "type" => "number",
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

        $this->controls["card_background"] = [
            "group" => "style",
            "label" => __( "Card Background", "cl-listing-collection" ),
            "type" => "background",
            "css" => [
                [
                    "property" => "background",
                    "selector" => ".cl-card",
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
                    "selector" => ".cl-card",
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
                    "selector" => ".cl-card-price",
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
                    "selector" => ".cl-card-address",
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
                    "selector" => ".cl-card-meta",
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
     * Resolve the community-scoped listing query, call the canonical search endpoint, and render SSR cards.
     */
    public function render() {
        $settings = is_array( $this->settings ) ? $this->settings : [];

        $community_key_raw = $settings["community_key_input"] ?? ( $settings["community_key"] ?? "" );
        $community_key = $this->render_dynamic_data( $community_key_raw );
        $community_key = is_scalar( $community_key ) ? trim( sanitize_text_field( (string) $community_key ) ) : "";
        if ( $this->is_unresolved_dynamic_placeholder( $community_key ) ) {
            $community_key = "";
        }
        if ( "" === $community_key ) {
            $this->log_warning( "Missing required community_key; rendering empty state." );
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

        $params = [
            "community_key" => $community_key,
            "limit" => $limit,
            "sort" => $normalized_sort["sort"],
            "order" => $normalized_sort["order"],
        ];

        $property_types = $this->normalize_multi_select_value( $settings["property_type"] ?? null );
        if ( [] !== $property_types ) {
            $params["property_type"] = implode( ",", $property_types );
        }

        $property_sub_types = $this->normalize_multi_select_value( $settings["property_subtype"] ?? null );
        if ( [] !== $property_sub_types ) {
            $params["property_subtype"] = implode( ",", $property_sub_types );
        }

        $statuses = $this->normalize_multi_select_value( $settings["status"] ?? null );
        if ( [] !== $statuses ) {
            $params["status"] = implode( ",", $statuses );
        }

        $price_min = \cllc_sanitize_float( $settings["price_min"] ?? null );
        $price_max = \cllc_sanitize_float( $settings["price_max"] ?? null );
        if ( null !== $price_min && null !== $price_max && $price_min > $price_max ) {
            $price_min = null;
            $price_max = null;
        }
        if ( null !== $price_min ) {
            $params["price_min"] = $price_min;
        }
        if ( null !== $price_max ) {
            $params["price_max"] = $price_max;
        }

        $beds_min = \cllc_sanitize_int( $settings["beds_min"] ?? null );
        if ( null !== $beds_min && $beds_min > 0 ) {
            $params["beds_min"] = $beds_min;
        }

        $baths_min = \cllc_sanitize_int( $settings["baths_min"] ?? null );
        if ( null !== $baths_min && $baths_min > 0 ) {
            $params["baths_min"] = $baths_min;
        }

        $response = \cllc_fetch_listings( $params );
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

        $grid_listings = [];
        foreach ( $items as $item ) {
            if ( ! is_array( $item ) ) {
                continue;
            }

            $listing_id = $item["listing_id"] ?? "";
            $link_url = "";
            if ( ! \cllc_is_blank( $listing_id ) ) {
                $link_url = home_url( "/listing/" . rawurlencode( (string) $listing_id ) . "/" );
            }

            $item["link_url"] = $link_url;
            $grid_listings[] = $item;
        }
        echo '<div class="cl-listing-carousel">';
        echo render_listing_grid( $grid_listings );
        echo '</div>';

        if ( $structured_data_mode === "itemlist" && ! $this->is_listing_detail_context() ) {
            $schema = $this->build_itemlist_schema( $items, $settings );
            if ( is_array( $schema ) ) {
                echo "<script type=\"application/ld+json\">";
                echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
                echo "</script>";
            }
        }
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

    private function build_itemlist_schema( array $items, array $settings ): ?array {
        if ( empty( $items ) ) {
            return null;
        }

        $item_list_elements = [];
        $position = 1;

        foreach ( $items as $item ) {
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
        $listing_id = $item["listing_id"] ?? "";
        if ( \cllc_is_blank( $listing_id ) ) {
            return "";
        }

        $link = home_url( "/listing/" . rawurlencode( (string) $listing_id ) . "/" );
        $link = esc_url_raw( $link );

        return $link !== "" ? $link : "";
    }

    private function resolve_item_name( array $item ): string {
        $address = $item["address"]["display"] ?? "";

        $address = trim( (string) $address );
        return $address;
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
        $style_url = plugins_url( "assets/css/listing-collection.css", CLLC_PLUGIN_FILE );
        $grid_style_url = plugins_url( "listing-grid/listing-grid.css", CLLC_PLUGIN_FILE );
        $card_style_url = plugins_url( "listing-card/listing-card.css", CLLC_PLUGIN_FILE );

        wp_enqueue_style( "cllc-listing-collection", $style_url, [], CLLC_VERSION );
        wp_enqueue_style( "cllc-listing-grid", $grid_style_url, [], CLLC_VERSION );
        wp_enqueue_style( "cllc-listing-card", $card_style_url, [], CLLC_VERSION );
    }

    private function get_property_type_options(): array {
        $defaults = [
            "Single Family Detached" => __( "Single Family Detached", "cl-listing-collection" ),
            "Single Family Attached" => __( "Single Family Attached", "cl-listing-collection" ),
            "Multi Family" => __( "Multi Family", "cl-listing-collection" ),
            "Vacant Land" => __( "Vacant Land", "cl-listing-collection" ),
        ];

        $options = apply_filters( "cllc_property_type_options", $defaults );
        if ( ! is_array( $options ) ) {
            return $defaults;
        }

        return $options;
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

    private function log_warning( string $message ): void {
        error_log( "[CL Listing Collection] " . $message ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
    }
}
