# Changelog

## 0.5.0 - 2026-07-24
### Added
- Topic-backed geographic scopes for the `cl-listing-carousel`: entire-topic and selected-feature requests through canonical `cl-reso-link` identifiers.

### Changed
- The carousel verifies topic `meta.applied_geo_scope` before rendering listings and fails closed on absent or mismatched scope confirmation.
- Existing saved carousel settings default to canonical geographic mode for backward compatibility.

## 0.4.0 - 2026-03-01
### Updated
- Adapted to canonical `address.display` field.
- Removed dependency on legacy non-canonical address fields.

## 0.3.0 - 2026-02-26
### Added
- JSON-LD ItemList structured data for listing carousel.
