<?php

if ( ! defined( "ABSPATH" ) ) {
    exit;
}

if ( ! function_exists( "esc_url" ) ) {
    return "";
}

function render_listing_card( array $listing, string $link_url ): string {
    if ( empty( $link_url ) ) {
        return "";
    }

    $media = isset( $listing["media"] ) && is_array( $listing["media"] ) ? $listing["media"] : [];
    $address = isset( $listing["address"] ) && is_array( $listing["address"] ) ? $listing["address"] : [];
    $market = isset( $listing["market"] ) && is_array( $listing["market"] ) ? $listing["market"] : [];
    $structure = isset( $listing["structure"] ) && is_array( $listing["structure"] ) ? $listing["structure"] : [];

    $primary_photo = $media["primary_photo"] ?? "";
    $address_display = $address["display"] ?? "";
    $has_address = isset( $address["display"] ) && (string) $address_display !== "";

    $price = $market["price"] ?? "";
    $has_price = isset( $market["price"] ) && (string) $price !== "";

    $beds = $structure["beds"] ?? null;
    $baths = $structure["baths"] ?? null;
    $sqft = $structure["sqft"] ?? null;

    $has_beds = isset( $beds ) && (string) $beds !== "";
    $has_baths = isset( $baths ) && (string) $baths !== "";
    $has_sqft = isset( $sqft ) && (string) $sqft !== "";
    $has_attributes = $has_beds || $has_baths || $has_sqft;

    ob_start();
    ?>
    <a class="cl-listing-card" href="<?php echo esc_url( $link_url ); ?>">
        <div class="cl-card-image">
            <?php if ( (string) $primary_photo !== "" ) : ?>
                <img src="<?php echo esc_url( $primary_photo ); ?>" alt="<?php echo esc_attr( $address_display ); ?>" />
            <?php else : ?>
                <div class="cl-card-image--placeholder"></div>
            <?php endif; ?>
        </div>
        <?php if ( $has_price ) : ?>
            <div class="cl-card-price"><?php echo '$' . esc_html( $price ); ?></div>
        <?php endif; ?>
        <?php if ( $has_address ) : ?>
            <div class="cl-card-address"><?php echo esc_html( $address_display ); ?></div>
        <?php endif; ?>
        <?php if ( $has_attributes ) : ?>
            <div class="cl-card-attributes">
                <?php if ( $has_beds ) : ?>
                    <span><?php echo esc_html( $beds ); ?></span>
                <?php endif; ?>
                <?php if ( $has_baths ) : ?>
                    <span><?php echo esc_html( $baths ); ?></span>
                <?php endif; ?>
                <?php if ( $has_sqft ) : ?>
                    <span><?php echo esc_html( $sqft ); ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </a>
    <?php

    return (string) ob_get_clean();
}
