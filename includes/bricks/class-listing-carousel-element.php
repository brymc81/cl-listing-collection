<?php

namespace CL_Listing_Collection\Bricks;

use Bricks\Element;

if ( ! defined( "ABSPATH" ) ) {
    exit;
}

class Listing_Carousel_Element extends Element {

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
        $this->controls["limit"] = [
            "group" => "query",
            "label" => __( "Limit", "cl-listing-collection" ),
            "type" => "number",
            "min" => 1,
            "max" => 100,
            "default" => 4,
        ];

        $this->controls["sort"] = [
            "group" => "query",
            "label" => __( "Sort", "cl-listing-collection" ),
            "type" => "select",
            "options" => [
                "relevance" => __( "Relevance", "cl-listing-collection" ),
                "newest" => __( "Newest", "cl-listing-collection" ),
                "modified" => __( "Modified", "cl-listing-collection" ),
                "price" => __( "Price", "cl-listing-collection" ),
                "dom" => __( "Days on Market", "cl-listing-collection" ),
                "distance" => __( "Distance", "cl-listing-collection" ),
            ],
            "default" => "relevance",
        ];

        $this->controls["status"] = [
            "group" => "query",
            "label" => __( "Status", "cl-listing-collection" ),
            "type" => "select",
            "options" => [
                "Active" => __( "Active", "cl-listing-collection" ),
                "Active Under Contract" => __( "Active Under Contract", "cl-listing-collection" ),
                "Closed" => __( "Closed", "cl-listing-collection" ),
                "Pending" => __( "Pending", "cl-listing-collection" ),
            ],
            "multiple" => true,
            "placeholder" => __( "Select status", "cl-listing-collection" ),
        ];

        $this->controls["property_type"] = [
            "group" => "query",
            "label" => __( "Property Type", "cl-listing-collection" ),
            "type" => "select",
            "options" => $this->get_property_type_options(),
            "multiple" => true,
            "placeholder" => __( "Select property types", "cl-listing-collection" ),
        ];

        $this->controls["property_subtype"] = [
            "group" => "query",
            "label" => __( "Property Subtype", "cl-listing-collection" ),
            "type" => "select",
            "options" => $this->get_property_subtype_options(),
            "multiple" => true,
            "placeholder" => __( "Select property subtypes", "cl-listing-collection" ),
        ];

        $this->controls["mls_area"] = [
            "group" => "query",
            "label" => __( "MLS Area", "cl-listing-collection" ),
            "type" => "select",
            "options" => $this->get_mls_area_options(),
            "multiple" => true,
            "placeholder" => __( "Select MLS areas", "cl-listing-collection" ),
        ];

        $this->controls["postal_code"] = [
            "group" => "query",
            "label" => __( "Postal Code", "cl-listing-collection" ),
            "type" => "text",
        ];

        $this->controls["geo_shape_id"] = [
            "group" => "query",
            "label" => __( "Geo Shape ID", "cl-listing-collection" ),
            "type" => "text",
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

        $this->controls["city"] = [
            "group" => "query",
            "label" => __( "City", "cl-listing-collection" ),
            "type" => "text",
        ];

        $this->controls["architecture_type"] = [
            "group" => "query",
            "label" => __( "Architecture Type", "cl-listing-collection" ),
            "type" => "text",
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

        $this->controls["sqft_min"] = [
            "group" => "query",
            "label" => __( "Sqft Min", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["sqft_max"] = [
            "group" => "query",
            "label" => __( "Sqft Max", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["acres_min"] = [
            "group" => "query",
            "label" => __( "Acres Min", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["acres_max"] = [
            "group" => "query",
            "label" => __( "Acres Max", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["year_min"] = [
            "group" => "query",
            "label" => __( "Year Min", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["year_max"] = [
            "group" => "query",
            "label" => __( "Year Max", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["q"] = [
            "group" => "query",
            "label" => __( "Query", "cl-listing-collection" ),
            "type" => "text",
        ];

        $this->controls["center_lat"] = [
            "group" => "advanced",
            "label" => __( "Center Latitude", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["center_lng"] = [
            "group" => "advanced",
            "label" => __( "Center Longitude", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["zoom"] = [
            "group" => "advanced",
            "label" => __( "Zoom", "cl-listing-collection" ),
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

    public function render() {
        $settings = is_array( $this->settings ) ? $this->settings : [];
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
        } elseif ( $limit > 100 ) {
            $limit = 100;
        }

        $allowed_sorts = [ "relevance", "newest", "modified", "price", "dom", "distance" ];
        $sort = isset( $settings["sort"] ) ? sanitize_text_field( (string) $settings["sort"] ) : "relevance";
        if ( ! in_array( $sort, $allowed_sorts, true ) ) {
            $sort = "relevance";
        }

        $order = isset( $settings["order"] ) ? strtolower( sanitize_text_field( (string) $settings["order"] ) ) : "desc";
        if ( ! in_array( $order, [ "asc", "desc" ], true ) ) {
            $order = "desc";
        }

        $params = [
            "limit" => $limit,
            "sort" => $sort,
            "order" => $order,
        ];

        $multi_select_fields = [
            "status",
            "property_type",
            "property_subtype",
            "mls_area",
        ];

        foreach ( $multi_select_fields as $field ) {
            $value = $settings[ $field ] ?? null;
            $serialized = $field === "mls_area"
                ? $this->normalize_mls_area_value( $value )
                : $this->normalize_multi_select_value( $value );
            if ( null !== $serialized ) {
                $params[ $field ] = $serialized;
            }
        }

        $text_fields = [
            "city",
            "postal_code",
            "q",
            "geo_shape_id",
        ];

        foreach ( $text_fields as $field ) {
            $value = $settings[ $field ] ?? null;
            if ( ! \cllc_is_blank( $value ) ) {
                $clean = sanitize_text_field( (string) $value );
                if ( $clean !== "" ) {
                    $params[ $field ] = $clean;
                }
            }
        }

        $architecture_type = $settings["architecture_type"] ?? null;
        if ( ! \cllc_is_blank( $architecture_type ) ) {
            $clean = sanitize_text_field( (string) $architecture_type );
            if ( $clean !== "" ) {
                $params["style"] = $clean;
            }
        }

        $numeric_fields = [
            "price_min",
            "price_max",
            "beds_min",
            "baths_min",
            "sqft_min",
            "sqft_max",
            "acres_min",
            "acres_max",
            "year_min",
            "year_max",
            "zoom",
        ];

        foreach ( $numeric_fields as $field ) {
            $value = \cllc_sanitize_int( $settings[ $field ] ?? null );
            if ( null !== $value ) {
                $params[ $field ] = $value;
            }
        }

        $center_lat = \cllc_sanitize_float( $settings["center_lat"] ?? null );
        if ( null !== $center_lat ) {
            $params["center_lat"] = $center_lat;
        }

        $center_lng = \cllc_sanitize_float( $settings["center_lng"] ?? null );
        if ( null !== $center_lng ) {
            $params["center_lng"] = $center_lng;
        }

        $response = \cllc_fetch_listings( $params );
        $items = isset( $response["items"] ) && is_array( $response["items"] ) ? $response["items"] : [];

        if ( ! empty( $response["error"] ) ) {
            return;
        }

        if ( empty( $response["decoded"] ) || empty( $items ) ) {
            return;
        }

        $this->enqueue_assets();

        $aspect_class = $this->resolve_aspect_ratio_class( $settings );
        $clickable = ! empty( $settings["clickable"] );
        $target = ! empty( $settings["open_in_new_tab"] ) ? "_blank" : "_self";

        foreach ( $items as $item ) {
            $this->render_card( $item, $clickable, $target, $aspect_class );
        }

        if ( $structured_data_mode === "itemlist" && ! $this->is_listing_detail_context() ) {
            $schema = $this->build_itemlist_schema( $items, $settings );
            if ( is_array( $schema ) ) {
                echo "<script type=\"application/ld+json\">";
                echo wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
                echo "</script>";
            }
        }
    }

    private function render_card( array $item, bool $clickable, string $target, string $aspect_class ): void {
        $listing_id = $item["listing_id"] ?? "";
        $link = $listing_id !== "" ? home_url( "/listing/" . rawurlencode( (string) $listing_id ) . "/" ) : "";

        $media_primary = "";
        if ( isset( $item["media"] ) && is_array( $item["media"] ) ) {
            $media_primary = $item["media"]["primary"] ?? "";
        }

        $address = $item["address"]["display"] ?? ""; // Canonical contract: address.display (cl-reso-link authority)

        $bedrooms = null;
        $bathrooms = null;
        $sqft = null;
        if ( isset( $item["structure"] ) && is_array( $item["structure"] ) ) {
            $bedrooms = $item["structure"]["bedrooms_total"] ?? null;
            $bathrooms = $item["structure"]["bathrooms_total"] ?? null;
            $sqft = $item["structure"]["building_area_total"] ?? null;
        }

        $price_value = null;
        if ( isset( $item["market"] ) && is_array( $item["market"] ) ) {
            if ( ! \cllc_is_blank( $item["market"]["close_price"] ?? null ) ) {
                $price_value = $item["market"]["close_price"];
            } else {
                $price_value = $item["market"]["list_price"] ?? null;
            }
        }

        $price = \cllc_format_price( $price_value );
        $is_clickable = $clickable && $link !== "";

        $card_classes = [ "cl-card" ];
        if ( $aspect_class !== "" ) {
            $card_classes[] = $aspect_class;
        }
        if ( $is_clickable ) {
            $card_classes[] = "is-clickable";
        }

        $attributes = "class=\"" . esc_attr( implode( " ", $card_classes ) ) . "\"";
        if ( $is_clickable ) {
            $attributes .= " data-url=\"" . esc_url( $link ) . "\" data-target=\"" . esc_attr( $target ) . "\"";
        }

        echo "<div " . $attributes . ">";
        if ( $media_primary !== "" ) {
            echo "<div class=\"cl-card-media\"><img src=\"" . esc_url( $media_primary ) . "\" alt=\"" . esc_attr( $address ) . "\" loading=\"lazy\" /></div>";
        }
        echo "<div class=\"cl-card-body\">";
        $status_badge = $this->render_status_badge( $item );
        if ( $status_badge !== "" ) {
            echo $status_badge;
        }
        if ( $price !== "" ) {
            echo "<div class=\"cl-card-price\">" . esc_html( $price ) . "</div>";
        }
        if ( $address !== "" ) {
            echo "<div class=\"cl-card-address\">" . esc_html( $address ) . "</div>";
        }

        $meta_items = [];
        if ( $bedrooms !== null && $bedrooms !== "" ) {
            $meta_items[] = esc_html( $bedrooms ) . " Beds";
        }
        if ( $bathrooms !== null && $bathrooms !== "" ) {
            $meta_items[] = esc_html( $bathrooms ) . " Baths";
        }
        if ( $sqft !== null && $sqft !== "" ) {
            $meta_items[] = esc_html( $sqft ) . " SqFt";
        }
        if ( ! empty( $meta_items ) ) {
            echo "<div class=\"cl-card-meta\">";
            foreach ( $meta_items as $meta_item ) {
                echo "<span class=\"cl-meta-item\">" . $meta_item . "</span>";
            }
            echo "</div>";
        }
        echo "</div>";
        echo "</div>";
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
        $address = $item["address"]["display"] ?? ""; // Canonical contract: address.display (cl-reso-link authority)

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
        $script_url = plugins_url( "assets/js/listing-collection.js", CLLC_PLUGIN_FILE );

        wp_enqueue_style( "cllc-listing-collection", $style_url, [], CLLC_VERSION );
        wp_enqueue_script( "cllc-listing-collection", $script_url, [], CLLC_VERSION, true );
    }

    private function get_property_type_options(): array {
        $defaults = [
            "Residential" => __( "Residential", "cl-listing-collection" ),
            "Multi-Family" => __( "Multi-Family", "cl-listing-collection" ),
            "Vacant Land" => __( "Vacant Land", "cl-listing-collection" ),
            "Commercial" => __( "Commercial", "cl-listing-collection" ),
            "Business Opportunity" => __( "Business Opportunity", "cl-listing-collection" ),
            "Farm" => __( "Farm", "cl-listing-collection" ),
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

    private function get_mls_area_options(): array {
        if ( ! function_exists( "cl_reso_link_get_mls_areas" ) ) {
            return [];
        }

        $areas = cl_reso_link_get_mls_areas();
        if ( ! is_array( $areas ) ) {
            return [];
        }

        $options = [];
        foreach ( $areas as $area ) {
            if ( ! is_array( $area ) ) {
                continue;
            }

            $code = $area["code"] ?? "";
            $label = $area["label"] ?? "";
            if ( \cllc_is_blank( $code ) || \cllc_is_blank( $label ) ) {
                continue;
            }

            $options[ (string) $code ] = (string) $label;
        }

        return $options;
    }

    private function normalize_multi_select_value( $value, array $label_map = [] ): ?string {
        if ( \cllc_is_blank( $value ) ) {
            return null;
        }

        if ( is_array( $value ) ) {
            $parts = [];
            foreach ( $value as $entry ) {
                if ( \cllc_is_blank( $entry ) ) {
                    continue;
                }

                $clean = sanitize_text_field( (string) $entry );
                if ( $clean !== "" ) {
                    $parts[] = $this->map_multi_select_value( $clean, $label_map );
                }
            }

            $parts = array_values( array_unique( array_filter( $parts, "strlen" ) ) );
            if ( empty( $parts ) ) {
                return null;
            }

            return implode( ",", $parts );
        }

        $clean = sanitize_text_field( (string) $value );
        if ( $clean === "" ) {
            return null;
        }

        $parts = strpos( $clean, "," ) !== false ? array_map( "trim", explode( ",", $clean ) ) : [ $clean ];
        $resolved = [];
        foreach ( $parts as $part ) {
            if ( $part === "" ) {
                continue;
            }

            $mapped = $this->map_multi_select_value( $part, $label_map );
            if ( $mapped !== "" ) {
                $resolved[] = $mapped;
            }
        }

        $resolved = array_values( array_unique( $resolved ) );
        if ( empty( $resolved ) ) {
            return null;
        }

        return implode( ",", $resolved );
    }

    private function map_multi_select_value( string $value, array $label_map ): string {
        if ( empty( $label_map ) ) {
            return $value;
        }

        $key = strtolower( trim( $value ) );
        return $label_map[ $key ] ?? $value;
    }

    private function normalize_mls_area_value( $value ): ?string {
        $options = $this->get_mls_area_options();
        if ( empty( $options ) ) {
            return $this->normalize_multi_select_value( $value );
        }

        $label_map = [];
        foreach ( $options as $code => $label ) {
            $label_key = strtolower( trim( (string) $label ) );
            if ( $label_key === "" ) {
                continue;
            }

            $label_map[ $label_key ] = (string) $code;
        }

        return $this->normalize_multi_select_value( $value, $label_map );
    }

    private function render_status_badge( array $item ): string {
        $status = $item["status"] ?? "";
        if ( \cllc_is_blank( $status ) ) {
            return "";
        }

        $label = trim( (string) $status );
        if ( $label === "" ) {
            return "";
        }

        $class = $this->resolve_status_class( $label );
        $classes = [ "cl-card-status" ];
        if ( $class !== "" ) {
            $classes[] = $class;
        }

        return "<div class=\"" . esc_attr( implode( " ", $classes ) ) . "\">" . esc_html( $label ) . "</div>";
    }

    private function resolve_status_class( string $status ): string {
        $normalized = strtolower( trim( preg_replace( '/\s+/', ' ', $status ) ) );

        if ( $normalized === "active" ) {
            return "cl-status-active";
        }

        if ( $normalized === "active under contract" ) {
            return "cl-status-active-under-contract";
        }

        if ( $normalized === "closed" || \cllc_is_closed_status( $status ) ) {
            return "cl-status-closed";
        }

        return "";
    }
}
