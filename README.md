# CL Listing Collection

Provides a native Bricks element, `CL Listing Carousel`, that renders SSR listing cards from the canonical `cl-reso-link` endpoint at `/api/properties/search`. This plugin is constrained to an editorial embed block and does not provide or own search UI.

## Element

Name: `cl-listing-carousel`
Label: `CL Listing Carousel`

## Controls

Data controls map 1:1 to canonical search params:
- `limit` (default 4, clamp 1..100)
- `sort` (`relevance`, `newest`, `modified`, `price`, `dom`, `distance`)
- `order` (`asc`, `desc`)
- `status`
- `city`
- `postal_code`
- `property_type`
- `property_subtype`
- `mls_area`
- `price_min`
- `price_max`
- `beds_min`
- `baths_min`
- `sqft_min`
- `sqft_max`
- `acres_min`
- `acres_max`
- `year_min`
- `year_max`
- `q`

Advanced:
- `center_lat`
- `center_lng`
- `zoom`
- `geo_shape_id`

Style:
- `card_background`
- `card_border_radius`
- `price_typography`
- `meta_typography`
- `image_aspect_ratio` (`1:1`, `4:3`, `16:9`)
- `clickable`
- `open_in_new_tab`

## Canonical Contract Fields Used

- `listing_id`
- `address.display`
- `market.list_price`
- `market.close_price`
- `structure.bedrooms_total`
- `structure.bathrooms_total`
- `structure.building_area_total`
- `media.primary`

## Notes

- SSR is the baseline. No JS slider library is used.
- Layout is controlled by the parent container (no internal grid/width enforcement).
- Per-request in-memory cache prevents duplicate identical API calls within a single page render.
- This element does not implement search UI or client-side filtering.
