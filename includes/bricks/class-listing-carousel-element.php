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
        $this->control_groups["layout"] = [
            "title" => __( "Layout", "cl-listing-collection" ),
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

        $this->controls["card_width"] = [
            "group" => "layout",
            "label" => __( "Card Width", "cl-listing-collection" ),
            "type" => "text",
            "default" => "320px",
        ];

        $this->controls["gap"] = [
            "group" => "layout",
            "label" => __( "Gap", "cl-listing-collection" ),
            "type" => "text",
            "default" => "20px",
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

        $card_width = \cllc_sanitize_css_size( $settings["card_width"] ?? "320px", "320px" );
        $gap = \cllc_sanitize_css_size( $settings["gap"] ?? "20px", "20px" );

        $instance_id = isset( $this->id ) ? (string) $this->id : wp_unique_id( "cllc-" );
        $scope_id = "brxe-" . sanitize_html_class( $instance_id );

        $response = \cllc_fetch_listings( $params );
        $items = isset( $response["items"] ) && is_array( $response["items"] ) ? $response["items"] : [];

        if ( ! empty( $response["error"] ) ) {
            echo "<div class=\"cl-carousel cl-carousel--error\"></div>";
            return;
        }

        if ( empty( $response["decoded"] ) || empty( $items ) ) {
            echo "<div class=\"cl-carousel cl-carousel--empty\"></div>";
            return;
        }

        echo "<div class=\"cl-carousel\" data-cllc-id=\"" . esc_attr( $instance_id ) . "\">";
        echo "<style>";
        echo "#" . esc_attr( $scope_id ) . " .cl-carousel__track{display:flex;gap:" . esc_attr( $gap ) . ";overflow-x:auto;scroll-snap-type:x mandatory;padding-bottom:8px;}";
        echo "#" . esc_attr( $scope_id ) . " .cl-card{flex:0 0 " . esc_attr( $card_width ) . ";scroll-snap-align:start;border:1px solid #e2e2e2;border-radius:10px;overflow:hidden;background:#fff;color:inherit;text-decoration:none;display:block;}";
        echo "#" . esc_attr( $scope_id ) . " .cl-card__media{width:100%;aspect-ratio:4/3;background:#f2f2f2;overflow:hidden;}";
        echo "#" . esc_attr( $scope_id ) . " .cl-card__media img{width:100%;height:100%;object-fit:cover;display:block;}";
        echo "#" . esc_attr( $scope_id ) . " .cl-card__body{padding:12px 14px;}";
        echo "#" . esc_attr( $scope_id ) . " .cl-card__price{font-weight:700;margin-bottom:4px;}";
        echo "#" . esc_attr( $scope_id ) . " .cl-card__address{font-size:0.95rem;margin-bottom:8px;}";
        echo "#" . esc_attr( $scope_id ) . " .cl-card__meta{display:flex;gap:10px;font-size:0.85rem;color:#555;}";
        echo "</style>";

        echo "<div class=\"cl-carousel__track\">";

        foreach ( $items as $item ) {
            $listing_id = $item["listing_id"] ?? "";
            $link = $listing_id !== "" ? home_url( "/listing/" . rawurlencode( (string) $listing_id ) . "/" ) : "#";

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
                $status_value = $item["market"]["status"] ?? ( $item["status"] ?? "" );
                $is_closed = \cllc_is_closed_status( $status_value );
                if ( $is_closed && isset( $item["market"]["close_price"] ) && $item["market"]["close_price"] !== "" && $item["market"]["close_price"] !== null ) {
                    $price_value = $item["market"]["close_price"];
                } else {
                    $price_value = $item["market"]["list_price"] ?? null;
                }
            }

            $price = \cllc_format_price( $price_value );

            echo "<a class=\"cl-card\" href=\"" . esc_url( $link ) . "\">";
            if ( $media_primary !== "" ) {
                echo "<div class=\"cl-card__media\"><img src=\"" . esc_url( $media_primary ) . "\" alt=\"" . esc_attr( $address ) . "\" loading=\"lazy\" /></div>";
            }
            echo "<div class=\"cl-card__body\">";
            if ( $price !== "" ) {
                echo "<div class=\"cl-card__price\">" . esc_html( $price ) . "</div>";
            }
            if ( $address !== "" ) {
                echo "<div class=\"cl-card__address\">" . esc_html( $address ) . "</div>";
            }
            echo "<div class=\"cl-card__meta\">";
            if ( $bedrooms !== null && $bedrooms !== "" ) {
                echo "<span>" . esc_html( $bedrooms ) . " Beds</span>";
            }
            if ( $bathrooms !== null && $bathrooms !== "" ) {
                echo "<span>" . esc_html( $bathrooms ) . " Baths</span>";
            }
            if ( $sqft !== null && $sqft !== "" ) {
                echo "<span>" . esc_html( $sqft ) . " SqFt</span>";
            }
            echo "</div>";
            echo "</div>";
            echo "</a>";
        }

        echo "</div>";
        echo "</div>";
    }
}
