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
        $this->control_groups["data"] = [
            "title" => __( "Data", "cl-listing-collection" ),
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
            "group" => "data",
            "label" => __( "Limit", "cl-listing-collection" ),
            "type" => "number",
            "min" => 1,
            "max" => 100,
            "default" => 4,
        ];

        $this->controls["sort"] = [
            "group" => "data",
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

        $this->controls["order"] = [
            "group" => "data",
            "label" => __( "Order", "cl-listing-collection" ),
            "type" => "select",
            "options" => [
                "desc" => __( "Desc", "cl-listing-collection" ),
                "asc" => __( "Asc", "cl-listing-collection" ),
            ],
            "default" => "desc",
        ];

        $this->controls["status"] = [
            "group" => "data",
            "label" => __( "Status", "cl-listing-collection" ),
            "type" => "text",
        ];

        $this->controls["city"] = [
            "group" => "data",
            "label" => __( "City", "cl-listing-collection" ),
            "type" => "text",
        ];

        $this->controls["postal_code"] = [
            "group" => "data",
            "label" => __( "Postal Code", "cl-listing-collection" ),
            "type" => "text",
        ];

        $this->controls["property_type"] = [
            "group" => "data",
            "label" => __( "Property Type", "cl-listing-collection" ),
            "type" => "text",
        ];

        $this->controls["property_subtype"] = [
            "group" => "data",
            "label" => __( "Property Subtype", "cl-listing-collection" ),
            "type" => "text",
        ];

        $this->controls["architecture_type"] = [
            "group" => "data",
            "label" => __( "Architecture Type", "cl-listing-collection" ),
            "type" => "text",
        ];

        $this->controls["mls_area"] = [
            "group" => "data",
            "label" => __( "MLS Area", "cl-listing-collection" ),
            "type" => "text",
        ];

        $this->controls["price_min"] = [
            "group" => "data",
            "label" => __( "Price Min", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["price_max"] = [
            "group" => "data",
            "label" => __( "Price Max", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["beds_min"] = [
            "group" => "data",
            "label" => __( "Beds Min", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["baths_min"] = [
            "group" => "data",
            "label" => __( "Baths Min", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["sqft_min"] = [
            "group" => "data",
            "label" => __( "Sqft Min", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["sqft_max"] = [
            "group" => "data",
            "label" => __( "Sqft Max", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["acres_min"] = [
            "group" => "data",
            "label" => __( "Acres Min", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["acres_max"] = [
            "group" => "data",
            "label" => __( "Acres Max", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["year_min"] = [
            "group" => "data",
            "label" => __( "Year Min", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["year_max"] = [
            "group" => "data",
            "label" => __( "Year Max", "cl-listing-collection" ),
            "type" => "number",
        ];

        $this->controls["q"] = [
            "group" => "data",
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

        $this->controls["geo_shape_id"] = [
            "group" => "advanced",
            "label" => __( "Geo Shape ID", "cl-listing-collection" ),
            "type" => "text",
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

        $text_fields = [
            "status",
            "city",
            "postal_code",
            "property_type",
            "property_subtype",
            "mls_area",
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
    }

    private function render_card( array $item, bool $clickable, string $target, string $aspect_class ): void {
        $listing_id = $item["listing_id"] ?? "";
        $link = $listing_id !== "" ? home_url( "/listing/" . rawurlencode( (string) $listing_id ) . "/" ) : "";

        $media_primary = "";
        if ( isset( $item["media"] ) && is_array( $item["media"] ) ) {
            $media_primary = $item["media"]["primary"] ?? "";
        }

        $address = "";
        if ( isset( $item["address"] ) && is_array( $item["address"] ) ) {
            $address = $item["address"]["display"] ?? "";
        }

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

    private function enqueue_assets(): void {
        $style_url = plugins_url( "assets/css/listing-collection.css", CLLC_PLUGIN_FILE );
        $script_url = plugins_url( "assets/js/listing-collection.js", CLLC_PLUGIN_FILE );

        wp_enqueue_style( "cllc-listing-collection", $style_url, [], CLLC_VERSION );
        wp_enqueue_script( "cllc-listing-collection", $script_url, [], CLLC_VERSION, true );
    }
}
