# cl-listing-collection

## Purpose

Collection-level presentation adapter for listing embeds and the `cl-listing-carousel` Bricks element.

This plugin consumes canonical listing data from `cl-reso-link` and renders SSR-first collection markup with optional frontend enhancement.

## Authority

- `cl-reso-link/docs/*` owns canonical search, listing, geography, map, and compliance contracts.
- This plugin must not define MLS meaning, search semantics, geographic semantics, or compliance meaning.
- Shared card rendering may be delegated to `cl-property-components` only when that card API remains canonical and stable.

## Required Behavior

- SSR markup is the baseline.
- Frontend JS may only enhance already-rendered markup.
- No MLS provider calls.
- No raw MLS field interpretation.
- No schema normalization.
- No invented fallback data.
- No compensation display.
- No local compliance text invented by the carousel.
- No URL guessing from slug, path, query context, listing ID, or community identity.
- No geographic guessing from slug, path, title, post metadata, or legacy community inputs.

## Geographic Resolution

- `geo_shape_id_input` is the preferred builder control key for geography-scoped listing collections.
- Resolve dynamic values with Bricks runtime methods before sanitizing.
- Sanitize after dynamic resolution.
- Convert resolved `geo_shape_id_input` to canonical `geo_shape_id` request filter.
- Preserve legacy saved `community_key` or `community_key_input` only when explicitly documented as backward compatibility.
- Legacy community inputs must not be inferred from URL, slug, path, post title, or frontend context.
- Legacy community inputs, when used, must map only to canonical `community` filter semantics allowed by current `cl-reso-link` docs.
- If no valid canonical geographic input is resolved, render the safe empty state.

## Canonical Data Use

- Canonical listing objects and compact compliance payloads must come from `cl-reso-link`.
- The carousel may only render fields already present in the canonical response.
- Listing detail links must come from canonical URL fields supplied by `cl-reso-link`; do not derive local route URLs from `listing_id`.
- If required compliance fields are missing, fail safe by omitting the affected listing or rendering an empty/error state according to the carousel contract.

## Shared Card Reuse

- `cl-property-components` may be used for listing cards when the card API is documented as stable.
- Carousel code must treat card rendering as presentation only.
- Card rendering must not become a schema, compliance, geography, URL, or query authority.

## Documentation

- Carousel contract: `docs/carousel-contract.md`
- Card contract for shared property cards: `../cl-property-components/docs/card-contract.md`
