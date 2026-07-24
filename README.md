# cl-listing-collection

## Purpose
SSR listing presentation plugin for collection-style embeds. The active Bricks element in this plugin is `cl-listing-carousel`.

Start with `docs/DOCS_AUTHORITY.md` for current documentation authority. Listing/search, compliance, canonical URLs, media, and listing meaning remain owned by `../cl-reso-link/docs/DOCS_AUTHORITY.md`; reusable card internals are delegated to `../cl-property-components/docs/DOCS_AUTHORITY.md`.

## Inputs
- Builder controls:
  - `location_source` (`canonical_shape`, the backward-compatible default, or `topic`)
  - canonical mode: `geo_shape_id_input`
  - topic mode: `topic_id_input`, `topic_mode` (`entire_topic` or `selected_feature`), and `topic_feature_id_input` for selected-feature mode
  - canonical listing filters such as `limit`, `sort`, `order`, `property_type`, `property_subtype`, `style`, `status`, `price_min`, `price_max`, `beds_min`, `baths_min`, `sqft_min`, `sqft_max`, `year_min`, `year_max`, `acres_min`, `acres_max`, and `primary_bedroom_main_level`

`property_type` is a single-select broad category. Its canonical values are `Residential` (the default), `Rental`, `Multi-Family`, and `Vacant Land`. `property_subtype` remains a separate narrower filter.

`style` accepts exact canonical values, including comma-separated multiple values, and forwards them to `cl-reso-link`. It does not infer or modify `property_subtype`; `cl-reso-link` remains authoritative for style meaning and search behavior.

Property-characteristic controls forward nonblank canonical filter values only. Final parameter meaning, ranges, validation, and query behavior remain authoritative in `cl-reso-link`.

## Output
- SSR listing cards
- carousel presentation mode
- optional ItemList structured data

## Dependencies
- `cl-reso-link`
- `/api/properties/search`

## Known Constraints
- Existing saved elements without `location_source` remain in canonical mode and continue using `geo_shape_id_input` without a resave
- Canonical and topic geography are mutually exclusive. The carousel sends either `geo_shape_id`, `topic_id`, or `topic_id` plus `topic_feature_id`—never a mixed request
- Topic IDs and child IDs are opaque canonical identifiers supplied to `cl-reso-link`; the carousel does not read GeoJSON or infer geography
- Topic responses must return matching `meta.applied_geo_scope`; a missing or mismatched scope renders the safe empty state rather than unscoped listings
- The initial engine topic is `short-term-rentals`; its current child identifiers are `str1` through `str9` and carry no local semantic interpretation
- The prior Community Key fallback has been removed; saved values under that legacy control are ignored
- dynamic geographic values are resolved with Bricks-native `render_dynamic_data()`, then sanitized
- this plugin consumes canonical listing fields only and does not perform client-side schema shaping
