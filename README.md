# cl-listing-collection

## Purpose
SSR listing presentation plugin for collection-style embeds. The active Bricks element in this plugin is `cl-listing-carousel`.

Start with `docs/DOCS_AUTHORITY.md` for current documentation authority. Listing/search, compliance, canonical URLs, media, and listing meaning remain owned by `../cl-reso-link/docs/DOCS_AUTHORITY.md`; reusable card internals are delegated to `../cl-property-components/docs/DOCS_AUTHORITY.md`.

## Inputs
- Builder controls:
  - `geo_shape_id_input`
  - canonical listing filters such as `limit`, `sort`, `order`, `property_type`, `property_subtype`, `status`, `price_min`, `price_max`, `beds_min`, and `baths_min`

`property_type` is a single-select broad category. Its canonical values are `Residential` (the default), `Rental`, `Multi-Family`, and `Vacant Land`. `property_subtype` remains a separate narrower filter.

## Output
- SSR listing cards
- carousel presentation mode
- optional ItemList structured data

## Dependencies
- `cl-reso-link`
- `/api/properties/search`

## Known Constraints
- `geo_shape_id_input` is the sole builder-facing geographic control; without a valid resolved value, the carousel renders its safe empty state
- The prior Community Key fallback has been removed; saved values under that legacy control are ignored
- dynamic geographic values are resolved with Bricks-native `render_dynamic_data()`, then sanitized
- this plugin consumes canonical listing fields only and does not perform client-side schema shaping
