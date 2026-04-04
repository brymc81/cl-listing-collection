<?php

declare( strict_types=1 );

if ( ! defined( "ABSPATH" ) ) {
    define( "ABSPATH", __DIR__ );
}

if ( ! function_exists( "esc_html" ) ) {
    function esc_html( $text ): string {
        return htmlspecialchars( (string) $text, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8" );
    }
}

if ( ! function_exists( "esc_attr" ) ) {
    function esc_attr( $text ): string {
        return htmlspecialchars( (string) $text, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8" );
    }
}

if ( ! function_exists( "esc_url" ) ) {
    function esc_url( $url ): string {
        return htmlspecialchars( (string) $url, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8" );
    }
}

require_once __DIR__ . "/listing-card.php";

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

function render_card_html( array $listing, string $link = "/listing/test" ): string {
    return render_listing_card( $listing, $link );
}

function contains( string $haystack, string $needle ): bool {
    return str_contains( $haystack, $needle );
}

function count_attribute_spans( string $html ): int {
    if ( ! preg_match( '/<div class="cl-card-attributes">(.*?)<\/div>/s', $html, $matches ) ) {
        return 0;
    }
    return substr_count( $matches[1], "<span>" );
}

function html_parses( string $html ): bool {
    if ( ! class_exists( "DOMDocument" ) ) {
        return false;
    }

    $dom = new DOMDocument();
    libxml_use_internal_errors( true );
    $loaded = $dom->loadHTML( "<!doctype html><html><body><div id=\"root\">" . $html . "</div></body></html>" );
    libxml_clear_errors();
    return (bool) $loaded;
}

// 1) Full Data
$full_listing = [
    "media" => [ "primary_photo" => "https://example.com/image.jpg" ],
    "address" => [ "display" => "123 Main St" ],
    "market" => [ "price" => "450000" ],
    "structure" => [
        "beds" => "3",
        "baths" => "2",
        "sqft" => "1800",
    ],
];
$full_html = render_card_html( $full_listing, "https://example.com/listing/1" );

assert_true( contains( $full_html, "<img " ), "Full data: image rendered" );
assert_true( contains( $full_html, "class=\"cl-card-price\"" ), "Full data: price rendered" );
assert_true( contains( $full_html, "class=\"cl-card-address\"" ), "Full data: address rendered" );
assert_true( contains( $full_html, "class=\"cl-card-attributes\"" ), "Full data: attributes wrapper rendered" );
assert_true( 3 === count_attribute_spans( $full_html ), "Full data: 3 attribute spans rendered" );

// 2) Missing Image
$missing_image_listing = [
    "address" => [ "display" => "No Photo Ave" ],
    "market" => [ "price" => "500000" ],
    "structure" => [ "beds" => "2" ],
];
$missing_image_html = render_card_html( $missing_image_listing );

assert_true( contains( $missing_image_html, "class=\"cl-card-image--placeholder\"" ), "Missing image: placeholder rendered" );
assert_true( ! contains( $missing_image_html, "<img " ), "Missing image: no img rendered" );

// 3) Missing Attributes
$missing_attributes_listing = [
    "media" => [ "primary_photo" => "https://example.com/image.jpg" ],
    "address" => [ "display" => "No Attr St" ],
    "market" => [ "price" => "700000" ],
];
$missing_attributes_html = render_card_html( $missing_attributes_listing );
assert_true( ! contains( $missing_attributes_html, "class=\"cl-card-attributes\"" ), "Missing attributes: no attributes wrapper rendered" );

// 4) Missing Price
$missing_price_listing = [
    "media" => [ "primary_photo" => "https://example.com/image.jpg" ],
    "address" => [ "display" => "No Price St" ],
    "structure" => [ "beds" => "1" ],
];
$missing_price_html = render_card_html( $missing_price_listing );
assert_true( ! contains( $missing_price_html, "class=\"cl-card-price\"" ), "Missing price: no price element rendered" );

// 5) Minimal Listing
$minimal_listing = [
    "address" => [ "display" => "Only Address Rd" ],
];
$minimal_html = render_card_html( $minimal_listing );

assert_true( contains( $minimal_html, "class=\"cl-listing-card\"" ), "Minimal listing: card wrapper rendered" );
assert_true( contains( $minimal_html, "class=\"cl-card-address\"" ), "Minimal listing: address rendered" );
assert_true( ! contains( $minimal_html, "class=\"cl-card-price\"" ), "Minimal listing: no price rendered" );
assert_true( ! contains( $minimal_html, "class=\"cl-card-attributes\"" ), "Minimal listing: no attributes rendered" );

// 6) Escaping Validation
$escaped_listing = [
    "media" => [ "primary_photo" => "https://example.com/image.jpg?x=1&y=2" ],
    "address" => [ "display" => "<b>123 & Main</b> \"Apt\"" ],
    "market" => [ "price" => "<script>alert(1)</script>" ],
    "structure" => [
        "beds" => "<i>3</i>",
    ],
];
$escaped_html = render_card_html( $escaped_listing, "https://example.com/listing?q=1&x=2" );

assert_true( str_contains( $escaped_html, "&lt;script&gt;alert(1)&lt;/script&gt;" ), "Escaping: price content escaped" );
assert_true( str_contains( $escaped_html, "&lt;b&gt;123 &amp; Main&lt;/b&gt; &quot;Apt&quot;" ), "Escaping: address content escaped" );
assert_true( str_contains( $escaped_html, "href=\"https://example.com/listing?q=1&amp;x=2\"" ), "Escaping: URL escaped in href" );

// HTML structure sanity check
$all_html = [
    $full_html,
    $missing_image_html,
    $missing_attributes_html,
    $missing_price_html,
    $minimal_html,
    $escaped_html,
];

foreach ( $all_html as $index => $html ) {
    if ( class_exists( "DOMDocument" ) ) {
        assert_true( html_parses( $html ), "HTML parse: case " . (string) ( $index + 1 ) . " parsed without malformed structure" );
    } else {
        echo "[SKIP] HTML parse: DOMDocument not available for case " . (string) ( $index + 1 ) . PHP_EOL;
    }
}

echo PHP_EOL . "Tests run: " . $tests_run . PHP_EOL;
echo "Failures: " . $tests_failed . PHP_EOL;

exit( $tests_failed > 0 ? 1 : 0 );
