<?php

if ( ! defined( "ABSPATH" ) ) {
    exit;
}

function render_listing_grid( array $listings ): string {
    ob_start();
    ?>
    <div class="cl-listing-grid">
        <?php foreach ( $listings as $listing ) : ?>
            <?php
            $link_url = isset( $listing["link_url"] ) ? (string) $listing["link_url"] : "";
            echo render_listing_card( $listing, $link_url );
            ?>
        <?php endforeach; ?>
    </div>
    <?php

    return (string) ob_get_clean();
}
