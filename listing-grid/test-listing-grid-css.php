<?php

declare( strict_types=1 );

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

$css_path = __DIR__ . "/listing-grid.css";
$css = is_readable( $css_path ) ? (string) file_get_contents( $css_path ) : "";

assert_true( $css !== "", "CSS fixture: listing-grid.css is readable" );
assert_true(
    str_contains( $css, ".cl-listing-carousel .clpc-card-link" )
        && str_contains( $css, "aspect-ratio: var(--cllc-image-ratio, 4 / 3);" )
        && str_contains( $css, "overflow: hidden;" ),
    "Carousel image frame: link owns fixed aspect ratio and clips portrait overflow"
);
assert_true(
    str_contains( $css, ".cl-listing-carousel .clpc-card-photo" )
        && str_contains( $css, "height: 100%;" )
        && str_contains( $css, "object-fit: cover;" )
        && str_contains( $css, "object-position: center;" ),
    "Carousel image: photo fills frame with cover crop"
);
assert_true(
    str_contains( $css, ".cl-listing-carousel .cl-listing-grid" )
        && str_contains( $css, "align-items: stretch;" ),
    "Carousel row: cards retain stable row alignment"
);

echo PHP_EOL . "Tests run: " . $tests_run . PHP_EOL;
echo "Failures: " . $tests_failed . PHP_EOL;

exit( $tests_failed > 0 ? 1 : 0 );
