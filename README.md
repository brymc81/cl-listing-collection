# cl-listing-collection

## Purpose
SSR listing presentation plugin for collection-style embeds. The active Bricks element in this plugin is `cl-listing-carousel`.

## Inputs
- Builder controls:
  - `community_key_input`
  - canonical listing filters such as `limit`, `sort`, `order`, `property_type`, `property_subtype`, `status`, `price_min`, `price_max`, `beds_min`, and `baths_min`
- Runtime fallback:
  - legacy saved `community_key`

## Output
- SSR listing cards
- carousel presentation mode
- optional ItemList structured data

## Dependencies
- `cl-reso-link`
- `/api/properties/search`

## Known Constraints
- `community_key_input` is the builder-facing community control
- runtime falls back to legacy `community_key`
- dynamic community values are resolved with Bricks-native `render_dynamic_data()`
- this plugin consumes canonical listing fields only and does not perform client-side schema shaping
